<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SemesterHelper;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $semesters = SemesterHelper::getSemesters();
        $selectedSemester = $request->get('semester', SemesterHelper::getCurrentSemester());

        $query = Course::where('lecturer_id', Auth::id());

        if ($selectedSemester) {
            $query->where('semester', $selectedSemester);
        }

        $courses = $query->get();

        return view('lecturer.courses.index', compact('courses', 'semesters', 'selectedSemester'));
    }

    public function show(Course $course)
    {
        $enrollments = Enrollment::where('course_id', $course->id)->with('student')->get();
        $sections = CourseSection::where('course_id', $course->id)->get();

        return view('lecturer.courses.show', compact('course', 'enrollments', 'sections'));
    }

    public function allCourses(Request $request)
    {
        $semesters = SemesterHelper::getSemesters();
        $selectedSemester = $request->get('semester', SemesterHelper::getCurrentSemester());

        $courses = Course::when($selectedSemester, function ($query) use ($selectedSemester) {
                            $query->where('semester', $selectedSemester);
                        })
                        ->get();

        return view('lecturer.courses.all', compact('courses', 'semesters', 'selectedSemester'));
    }

    public function detail(Course $course)
    {
        $sections = CourseSection::where('course_id', $course->id)
                                ->with(['assignments', 'materials', 'quizzes'])
                                ->get();

        return view('lecturer.courses.detail', compact('course', 'sections'));
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

        return redirect()->route('lecturer.courses.show', $course)->with('success', 'Course section has been added.');
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

        return redirect()->route('lecturer.courses.show', $course)->with('success', 'Course section has been updated.');
    }

    public function deleteSection(Course $course, CourseSection $section)
    {
        $section->delete();

        return redirect()->route('lecturer.courses.show', $course)->with('success', 'Course section has been deleted.');
    }
}
