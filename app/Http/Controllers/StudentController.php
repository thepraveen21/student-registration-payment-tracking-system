<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // If using QR codes

class StudentController extends Controller
{
    /**
     * Display a paginated list of students with optional search.
     */
    public function index(Request $request)
    {
        $query = Student::with('course');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $students = $query->latest()->paginate(10);
        
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.students.create', compact('courses'));
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
            'status' => 'required|in:active,inactive',
        ]);

        // Generate registration number
        $registrationNumber = 'REG-' . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);
        
        // Generate QR code (always generate as per SRS requirements)
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(200)->generate($registrationNumber);
        $fileName = 'qrcode_' . $registrationNumber . '_' . time() . '.svg';
        $qrCodePath = 'qrcodes/' . $fileName;
        
        // Ensure the qrcodes directory exists
        \Storage::disk('public')->makeDirectory('qrcodes');
        \Storage::disk('public')->put($qrCodePath, $qrCode);

        $student = new Student();
        $student->fill($request->all());
        $student->registration_number = $registrationNumber;
        $student->qr_code_path = $qrCodePath;
        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load('course', 'payments');
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('admin.students.edit', compact('student', 'courses'));
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
            'status' => 'required|in:active,inactive',
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        // Delete associated QR code if exists
        if ($student->qr_code_path) {
            \Storage::disk('public')->delete($student->qr_code_path);
        }
        
        $student->delete();
        
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}