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
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalStudents = User::where('role', 'student')->count();
        $totalCourses = Course::count();

        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'totalTeachers', 'totalStudents', 'totalCourses'));
    }
}
