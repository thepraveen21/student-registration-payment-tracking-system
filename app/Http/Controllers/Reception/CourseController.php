<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(10);
        return view('reception.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('reception.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'fee' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Course::create($request->all());

        return redirect()->route('reception.courses.index')->with('success', 'Course added successfully.');
    }

    public function edit(Course $course)
    {
        return view('reception.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'fee' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $course->update($request->all());

        return redirect()->route('reception.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('reception.courses.index')->with('success', 'Course deleted successfully.');
    }
}
