<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        $recentCourses = Course::where('teacher_id', $teacherId)->orderBy('created_at', 'desc')->take(5)->get();
        $upcomingAssignments = Assignment::whereHas('section.course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->where('due_date', '>=', now())->orderBy('due_date')->take(5)->get();
        $recentSubmissions = Submission::whereHas('assignment.section.course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('created_at', 'desc')->take(5)->get();

        return view('teacher.dashboard', compact('recentCourses', 'upcomingAssignments', 'recentSubmissions'));
    }
}
