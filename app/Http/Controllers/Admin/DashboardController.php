<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalLecturers = User::where('role', 'lecturer')->count();
        $totalStudents = User::where('role', 'student')->count();
        $totalCourses = Course::count();

        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'totalLecturers', 'totalStudents', 'totalCourses'));
    }
}
