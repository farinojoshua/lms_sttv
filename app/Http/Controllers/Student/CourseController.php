<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $enrolledCourseIds = Enrollment::where('student_id', Auth::id())->pluck('course_id');
        $courses = Course::whereNotIn('id', $enrolledCourseIds)->get();

        return view('student.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $sections = CourseSection::where('course_id', $course->id)->with('assignments', 'materials')->get();

        return view('student.courses.show', compact('course', 'sections'));
    }

    public function enroll(Course $course)
    {
        Enrollment::create([
            'student_id' => Auth::id(),
            'course_id' => $course->id,
        ]);

        return redirect()->route('student.courses.enrolled')->with('success', 'Anda berhasil mendaftar ke mata kuliah ini.');
    }

    public function unenroll(Course $course)
    {
        Enrollment::where('student_id', Auth::id())->where('course_id', $course->id)->delete();

        return redirect()->route('student.courses.enrolled')->with('success', 'Anda berhasil membatalkan pendaftaran dari mata kuliah ini.');
    }

    public function enrolled()
    {
        $courses = Enrollment::where('student_id', Auth::id())->with('course.lecturer')->get()->pluck('course');

        return view('student.courses.enrolled', compact('courses'));
    }
}
