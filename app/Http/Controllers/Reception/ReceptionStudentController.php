<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\Center; // Import the Center model
use App\Models\QRCode as QRCodeModel;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class ReceptionStudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        // Eager-load both course and center
        $students = Student::with(['course', 'center'])->orderBy('id', 'asc')->paginate(10);
        return view('reception.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $courses = Course::all();
        $centers = Center::all(); // Fetch all centers
        return view('reception.students.create', compact('courses', 'centers'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email',
            'student_phone' => 'required|string|max:20',
            'parent_phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:500',
            'course_id' => 'required|exists:courses,id',
            'center_id' => 'nullable|exists:centers,id', // Center validation
            'status' => 'required|in:active,inactive',
        ]);

        // Generate registration number
        $registrationNumber = Student::generateRegistrationNumber('REG-');

        // Save student
        $student = Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'student_phone' => $request->student_phone,
            'parent_phone' => $request->parent_phone,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'course_id' => $request->course_id,
            'center_id' => $request->center_id, // <-- save center
            'status' => $request->status,
            'registration_number' => $registrationNumber,
        ]);

        // QR code assignment logic remains exactly the same
        $student->refresh();
        $scannedCode = $request->input('qr_code');
        if ($scannedCode) {
            $scannedCode = trim($scannedCode);
            if (strpos($scannedCode, '/') !== false) {
                $parts = explode('/', rtrim($scannedCode, '/'));
                $scannedCode = end($parts);
            }
        }

        if ($scannedCode) {
            $assigned = false;
            try {
                \DB::transaction(function () use ($scannedCode, $student, & $assigned) {
                    $qrRecord = QRCodeModel::where('code', $scannedCode)
                        ->lockForUpdate()
                        ->first();

                    if (!$qrRecord) {
                        $assigned = false;
                        return;
                    }

                    if ($qrRecord->student_id && $qrRecord->student_id != $student->id) {
                        throw new \Exception('Scanned QR code is already assigned to another student.');
                    }

                    $existingAssigned = QRCodeModel::where('student_id', $student->id)
                        ->lockForUpdate()
                        ->first();

                    if ($existingAssigned && $existingAssigned->id != $qrRecord->id) {
                        $existingAssigned->student_id = null;
                        $existingAssigned->is_assigned = false;
                        $existingAssigned->save();
                    }

                    $qrRecord->student_id = $student->id;
                    $qrRecord->is_assigned = true;
                    $qrRecord->save();

                    $student->qr_code_path = $qrRecord->qr_image_path;
                    $student->save();

                    $assigned = true;
                });

                if ($assigned) {
                    return redirect()->route('reception.students.show', $student)
                                    ->with('success', 'Student added and QR assigned.');
                }
            } catch (\Exception $e) {
                try { $student->delete(); } catch (\Exception $_) {}
                return redirect()->back()->with('error', 'This QR has already been assigned.');
            }
        }

        // Generate QR if none exists
        if (!$student->qrCode) {
            $qrCodeUrl = route('qr.show', $registrationNumber);
            $qrCodeImage = QrCode::format('svg')->size(200)->generate($qrCodeUrl);
            $fileName = 'qrcode_' . $registrationNumber . '_' . time() . '.svg';
            $qrCodeDirectory = public_path('qrcodes');
            $qrCodePath = 'qrcodes/' . $fileName;

            if (!file_exists($qrCodeDirectory)) {
                mkdir($qrCodeDirectory, 0755, true);
            }
            file_put_contents(public_path($qrCodePath), $qrCodeImage);

            $student->qr_code_path = $qrCodePath;
            $student->save();

            $qrCode = new QRCodeModel();
            $qrCode->code = $registrationNumber;
            $qrCode->qr_image_path = $qrCodePath;
            $qrCode->student_id = $student->id;
            $qrCode->is_assigned = true;
            $qrCode->save();
        } else {
            if (!$student->qr_code_path && $student->qrCode->qr_image_path) {
                $student->qr_code_path = $student->qrCode->qr_image_path;
                $student->save();
            }
        }

        return redirect()->route('reception.students.show', $student)
                        ->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified student. ===25/12/03 updated===
     */
    // public function show(Student $student)
    // {
    //     // Eager-load center as well
    //     $student->load('center');
    //     return view('reception.students.show', compact('student'));
    // }
    public function show(Student $student)
    {
        // Eager-load center and qrCode as well to avoid N+1 queries
        $student->load(['center', 'qrCode']);
        return view('reception.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        $centers = Center::all(); // Fetch all centers
        return view('reception.students.edit', compact('student', 'courses', 'centers'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'student_phone' => 'required|string|max:20',
            'parent_phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:500',
            'course_id' => 'required|exists:courses,id',
            'center_id' => 'nullable|exists:centers,id', // Added validation for center_id
            'status' => 'required|in:active,inactive',
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'student_phone' => $request->student_phone,
            'parent_phone' => $request->parent_phone,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'course_id' => $request->course_id,
            'center_id' => $request->center_id, // <-- save the center
            'status' => $request->status,
        ]);

        return redirect()->route('reception.students.index')
                        ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('reception.students.index')
                        ->with('success', 'Student deleted successfully.');
    }
}
