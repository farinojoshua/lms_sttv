<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();
        $courses = Course::where('teacher_id', $teacherId)->with(['sections.assignments.submissions.student'])->get();

        return view('teacher.grades.index', compact('courses'));
    }
}
