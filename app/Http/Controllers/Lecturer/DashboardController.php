<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $lecturerId = Auth::id();

        $recentCourses = Course::where('lecturer_id', $lecturerId)->orderBy('created_at', 'desc')->take(5)->get();
        $upcomingAssignments = Assignment::whereHas('section.course', function ($query) use ($lecturerId) {
            $query->where('lecturer_id', $lecturerId);
        })->where('due_date', '>=', now())->orderBy('due_date')->take(5)->get();
        $recentSubmissions = Submission::whereHas('assignment.section.course', function ($query) use ($lecturerId) {
            $query->where('lecturer_id', $lecturerId);
        })->orderBy('created_at', 'desc')->take(5)->get();

        return view('lecturer.dashboard', compact('recentCourses', 'upcomingAssignments', 'recentSubmissions'));
    }
}
