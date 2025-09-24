<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class ReceptionStudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('reception.students.index', compact('students'));
    }

    public function create()
    {
        return view('reception.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        Student::create($request->all());

        return redirect()->route('reception.students.index')
                         ->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        return view('reception.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('reception.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
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
