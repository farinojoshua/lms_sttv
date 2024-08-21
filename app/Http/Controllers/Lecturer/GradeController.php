<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $courses = Course::where('lecturer_id', Auth::id())
                        ->with(['sections.assignments.submissions.student'])
                        ->get();

        return view('lecturer.grades.index', compact('courses'));
    }
}
