<?php

namespace App\Http\Controllers\Re        // Generate QR code (always generate as per SRS requirements)
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(200)->generate($registrationNumber);
        $fileName = 'qrcode_' . $registrationNumber . '_' . time() . '.svg';
        $qrCodePath = 'qrcodes/' . $fileName;ion;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class ReceptionStudentController extends Controller
{
    public function index()
    {
        $students = Student::with('course')->get();
        return view('reception.students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('reception.students.create', compact('courses'));
    }

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

        return redirect()->route('reception.students.index')
                         ->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        return view('reception.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('reception.students.edit', compact('student', 'courses'));
    }

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

        return redirect()->route('reception.students.index')
                         ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('reception.students.index')
                         ->with('success', 'Student deleted successfully.');
    }
}
