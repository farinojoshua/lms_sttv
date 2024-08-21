<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();
        $submissions = Submission::where('student_id', $studentId)
            ->with('assignment.section.course')
            ->get();

        return view('student.grades.index', compact('submissions'));
    }
}
