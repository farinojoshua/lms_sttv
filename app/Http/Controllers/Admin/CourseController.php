<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('lecturer')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $lecturers = User::where('role', 'lecturer')->get();
        return view('admin.courses.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lecturer_id' => 'required|exists:users,id',
            'semester' => 'nullable|string',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course has been created.');
    }

    public function edit(Course $course)
    {
        $lecturers = User::where('role', 'lecturer')->get();
        return view('admin.courses.edit', compact('course', 'lecturers'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lecturer_id' => 'required|exists:users,id',
            'semester' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course has been updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course has been deleted.');
    }
}
