<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $lecturerId = Auth::id();
        $courses = Course::where('lecturer_id', $lecturerId)->with(['sections.assignments.submissions.student'])->get();

        return view('lecturer.grades.index', compact('courses'));
    }
}
