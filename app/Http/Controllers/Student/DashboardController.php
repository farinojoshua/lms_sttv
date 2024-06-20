<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();

        $enrollments = Enrollment::where('student_id', $studentId)->with('course')->get();
        $upcomingAssignments = Assignment::whereHas('section.course.enrollments', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->where('due_date', '>=', now())->orderBy('due_date')->take(5)->get();
        $recentSubmissions = Submission::where('student_id', $studentId)->orderBy('created_at', 'desc')->take(5)->get();

        return view('student.dashboard', compact('enrollments', 'upcomingAssignments', 'recentSubmissions'));
    }
}
