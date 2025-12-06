<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\QRCode as QRCodeModel;

class StudentController extends Controller
{
    /**
     * Display a paginated list of students with optional search.
     */
    public function index(Request $request)
    {
        $query = Student::with('course', 'center');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);
        $students = $query->orderBy('id')->paginate($perPage);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $courses = Course::all();
        $centers = Center::all();

        return view('admin.students.create', compact('courses', 'centers'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:students,email',
            'student_phone' => 'nullable|string|max:20',
            'parent_phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:500',
            'course_id' => 'required|exists:courses,id',
            'center_id' => 'nullable|exists:centers,id',
            'status' => 'required|in:active,inactive',
            'qr_code' => 'nullable|string',
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

        // QR code assignment logic
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
                    return redirect()->route('admin.students.show', $student)
                                    ->with('success', 'Student added and QR assigned.');
                }
            } catch (\Exception $e) {
                try { $student->delete(); } catch (\Exception $_) {}
                return redirect()->back()->with('error', 'This QR has already been assigned.');
            }
        } else { // No scanned code, generate new QR
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
        }
        
        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Student registered successfully.');
    }

    /**
     * Display a single student.
     */
    public function show(Student $student)
    {
        $student->load('course', 'payments', 'center');

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        $centers = Center::all();

        return view('admin.students.edit', compact('student', 'courses', 'centers'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email',
            'student_phone' => 'nullable',
            'parent_phone' => 'required',
            'date_of_birth' => 'required',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required',
            'center_id' => 'nullable|exists:centers,id',
            'qr_code' => 'nullable|string',
        ]);

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->student_phone = $request->student_phone;
        $student->parent_phone = $request->parent_phone;
        $student->date_of_birth = $request->date_of_birth;
        $student->address = $request->address;
        $student->course_id = $request->course_id;
        $student->status = $request->status;
        $student->center_id = $request->center_id;

        // QR code assignment logic
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
                    $assigned = true;
                });

                if (!$assigned) {
                    return redirect()->back()->with('error', 'The provided QR code is not valid.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'This QR has already been assigned.');
            }
        }

        $student->save();

        return redirect()
            ->route('admin.students.show', $student)
            ->with('success', 'Student updated successfully');
    }

    /**
     * Remove specified student.
     */
    public function destroy(Student $student)
    {
        if ($student->qr_code_path) {
            Storage::disk('public')->delete($student->qr_code_path);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * QR Lookup form
     */
    public function lookupForm()
    {
        return view('students.lookup');
    }

    /**
     * QR Lookup
     */
    public function lookup(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);

        $student = Student::where('registration_number', $request->qr_code)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found for this QR code.');
        }

        return view('students.details', compact('student'));
    }
}
