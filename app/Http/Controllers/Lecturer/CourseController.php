<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        // Mendapatkan kursus yang diajar oleh dosen yang sedang login
        $courses = Course::where('lecturer_id', Auth::id())->get();

        return view('lecturer.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        // Mendapatkan mahasiswa yang terdaftar di kursus
        $enrollments = Enrollment::where('course_id', $course->id)->with('student')->get();
        $sections = CourseSection::where('course_id', $course->id)->get();

        return view('lecturer.courses.show', compact('course', 'enrollments', 'sections'));
    }

    public function addSection(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CourseSection::create([
            'course_id' => $course->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('lecturer.courses.show', $course)->with('success', 'Bagian kursus berhasil ditambahkan.');
    }

    public function editSection(Course $course, CourseSection $section)
    {
        return view('lecturer.sections.edit', compact('course', 'section'));
    }

    public function updateSection(Request $request, Course $course, CourseSection $section)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $section->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('lecturer.courses.show', $course)->with('success', 'Bagian kursus berhasil diperbarui.');
    }

    public function deleteSection(Course $course, CourseSection $section)
    {
        $section->delete();

        return redirect()->route('lecturer.courses.show', $course)->with('success', 'Bagian kursus berhasil dihapus.');
    }
}
