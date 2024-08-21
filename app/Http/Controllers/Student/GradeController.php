<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\QuizSubmission;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();

        // Load assignment submissions
        $assignmentSubmissions = Submission::where('student_id', $studentId)
            ->with('assignment.section.course')
            ->get();

        // Load quiz submissions
        $quizSubmissions = QuizSubmission::where('student_id', $studentId)
            ->with('quiz.section.course')
            ->get();

        return view('student.grades.index', compact('assignmentSubmissions', 'quizSubmissions'));
    }
}

