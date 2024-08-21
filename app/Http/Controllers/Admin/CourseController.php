<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\SemesterHelper;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        // Customize how many years back you want to go
        $semesters = SemesterHelper::getSemesters(10);  // Example: 10 years back
        $selectedSemester = $request->get('semester', SemesterHelper::getCurrentSemester());

        $courses = Course::with('lecturer')
            ->when($selectedSemester, function ($query) use ($selectedSemester) {
                $query->where('semester', $selectedSemester);
            })
            ->get();

        return view('admin.courses.index', compact('courses', 'semesters', 'selectedSemester'));
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
            'code' => 'required|string|max:255|unique:courses,code',
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
            'code' => 'required|string|max:255|unique:courses,code,' . $course->id,
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
