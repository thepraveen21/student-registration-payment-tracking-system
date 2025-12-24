<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('students')->paginate(10);
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::withCount('students')->latest()->get();
        return view('courses.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
        ]);

        Course::create($request->only(['name', 'description', 'duration']));

        return redirect()->back()->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $course = Course::findOrFail($id);
            
            // Check if course has students
            if ($course->students()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete course. It has ' . $course->students()->count() . ' student(s) enrolled in it.');
            }
            
            $courseName = $course->name;
            $course->delete();
            
            return redirect()->back()->with('success', 'Course "' . $courseName . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete course: ' . $e->getMessage());
        }
    }
}
