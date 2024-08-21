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
    public function myCourses(Request $request)
    {
        $semesters = SemesterHelper::getSemesters();
        $selectedSemester = $request->get('semester', SemesterHelper::getCurrentSemester());

        $courses = Course::where('lecturer_id', Auth::id())
                         ->when($selectedSemester, function ($query) use ($selectedSemester) {
                             $query->where('semester', $selectedSemester);
                         })
                         ->get();

        return view('lecturer.courses.my_courses', compact('courses', 'semesters', 'selectedSemester'));
    }

    public function allAvailableCourses(Request $request)
    {
        $semesters = SemesterHelper::getSemesters();
        $selectedSemester = $request->get('semester', SemesterHelper::getCurrentSemester());

        $courses = Course::when($selectedSemester, function ($query) use ($selectedSemester) {
                            $query->where('semester', $selectedSemester);
                        })
                        ->get();

        return view('lecturer.courses.all_courses', compact('courses', 'semesters', 'selectedSemester'));
    }

    public function showMyCourse(Course $course)
    {
        $enrollments = Enrollment::where('course_id', $course->id)->with('student')->get();
        $sections = CourseSection::where('course_id', $course->id)->get();

        return view('lecturer.courses.show_my_course', compact('course', 'enrollments', 'sections'));
    }

    public function showCourseDetail(Course $course)
    {
        $sections = CourseSection::where('course_id', $course->id)
                                 ->with(['assignments', 'materials', 'quizzes'])
                                 ->get();

        return view('lecturer.courses.course_detail', compact('course', 'sections'));
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

        return redirect()->route('lecturer.courses.showMyCourse', $course)->with('success', 'Course section has been added.');
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

        return redirect()->route('lecturer.courses.showMyCourse', $course)->with('success', 'Course section has been updated.');
    }

    public function deleteSection(Course $course, CourseSection $section)
    {
        $section->delete();

        return redirect()->route('lecturer.courses.showMyCourse', $course)->with('success', 'Course section has been deleted.');
    }
}
