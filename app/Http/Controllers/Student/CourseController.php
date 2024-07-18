<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SemesterHelper;
use Illuminate\Http\Request;

class CourseController extends Controller
{
        public function index(Request $request)
    {
        $semesters = SemesterHelper::getSemesters();
        $selectedSemester = $request->get('semester', SemesterHelper::getCurrentSemester());

        $enrolledCourseIds = Enrollment::where('student_id', Auth::id())->pluck('course_id');
        $courses = Course::whereNotIn('id', $enrolledCourseIds)
                         ->when($selectedSemester, function ($query) use ($selectedSemester) {
                             $query->where('semester', $selectedSemester);
                         })
                         ->get();

        return view('student.courses.index', compact('courses', 'semesters', 'selectedSemester'));
    }

    public function show(Course $course)
    {
        $sections = CourseSection::where('course_id', $course->id)
                                 ->with('assignments', 'materials')
                                 ->get();

        return view('student.courses.show', compact('course', 'sections'));
    }

    public function enroll(Course $course)
    {
        Enrollment::create([
            'student_id' => Auth::id(),
            'course_id' => $course->id,
        ]);

        return redirect()->route('student.courses.enrolled')->with('success', 'You have successfully enrolled in this course.');
    }

    public function unenroll(Course $course)
    {
        Enrollment::where('student_id', Auth::id())
                  ->where('course_id', $course->id)
                  ->delete();

        return redirect()->route('student.courses.enrolled')->with('success', 'You have successfully unenrolled from this course.');
    }

    public function enrolled(Request $request)
    {
        $semesters = SemesterHelper::getSemesters();
        $selectedSemester = $request->get('semester', SemesterHelper::getCurrentSemester());

        $courses = Enrollment::where('student_id', Auth::id())
                             ->with('course.lecturer')
                             ->when($selectedSemester, function ($query) use ($selectedSemester) {
                                 $query->whereHas('course', function ($q) use ($selectedSemester) {
                                     $q->where('semester', $selectedSemester);
                                 });
                             })
                             ->get()
                             ->pluck('course');

        return view('student.courses.enrolled', compact('courses', 'semesters', 'selectedSemester'));
    }
}
