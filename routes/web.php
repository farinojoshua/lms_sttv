<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\MaterialController as TeacherMaterialController;
use App\Http\Controllers\Teacher\AssignmentController as TeacherAssignmentController;
use App\Http\Controllers\Teacher\GradeController as TeacherGradeController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\SubmissionController as StudentSubmissionController;
use App\Http\Controllers\Student\MaterialController as StudentMaterialController;
use App\Http\Controllers\Student\AssignmentController as StudentAssignmentController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'teacher':
                return redirect()->route('teacher.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            default:
                return view('dashboard');
        }
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('courses', AdminCourseController::class);
        Route::resource('users', AdminUserController::class);
        Route::post('users/import', [AdminUserController::class, 'import'])->name('users.import');
    });

    // Teacher Routes
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
        Route::resource('courses', TeacherCourseController::class)->only(['index', 'show']);
        Route::post('courses/{course}/sections', [TeacherCourseController::class, 'addSection'])->name('courses.addSection');
        Route::get('courses/{course}/sections/{section}/edit', [TeacherCourseController::class, 'editSection'])->name('courses.editSection');
        Route::put('courses/{course}/sections/{section}', [TeacherCourseController::class, 'updateSection'])->name('courses.updateSection');
        Route::delete('courses/{course}/sections/{section}', [TeacherCourseController::class, 'deleteSection'])->name('courses.deleteSection');
        Route::resource('sections.materials', TeacherMaterialController::class);
        Route::resource('sections.assignments', TeacherAssignmentController::class);
        Route::get('sections/{section}/assignments/{assignment}/submissions', [TeacherAssignmentController::class, 'showSubmissions'])->name('sections.assignments.submissions');
        Route::post('submissions/{submission}/grade', [TeacherAssignmentController::class, 'grade'])->name('submissions.grade');
        Route::get('grades', [TeacherGradeController::class, 'index'])->name('grades.index');
    });


    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::resource('courses', StudentCourseController::class)->only(['index', 'show']);
        Route::get('enrolled-courses', [StudentCourseController::class, 'enrolled'])->name('courses.enrolled');
        Route::post('courses/{course}/enroll', [StudentCourseController::class, 'enroll'])->name('courses.enroll');
        Route::delete('courses/{course}/unenroll', [StudentCourseController::class, 'unenroll'])->name('courses.unenroll');

        Route::get('sections/{section}/materials/{material}', [StudentMaterialController::class, 'show'])->name('materials.show');
        Route::get('sections/{section}/assignments/{assignment}', [StudentAssignmentController::class, 'show'])->name('assignments.show');

        Route::get('assignments/{assignment}/submit', [StudentSubmissionController::class, 'create'])->name('assignments.submit.create');
        Route::post('assignments/{assignment}/submit', [StudentSubmissionController::class, 'store'])->name('assignments.submit');
        Route::get('submissions/{submission}/edit', [StudentSubmissionController::class, 'edit'])->name('submissions.edit');
        Route::post('submissions/{submission}/update', [StudentSubmissionController::class, 'update'])->name('submissions.update');
        Route::get('grades', [StudentGradeController::class, 'index'])->name('grades.index');
    });



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
