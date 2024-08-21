<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Lecturer\GradeController as LecturerGradeController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Lecturer\CourseController as LecturerCourseController;
use App\Http\Controllers\Student\MaterialController as StudentMaterialController;
use App\Http\Controllers\Lecturer\MaterialController as LecturerMaterialController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Lecturer\DashboardController as LecturerDashboardController;
use App\Http\Controllers\Student\AssignmentController as StudentAssignmentController;
use App\Http\Controllers\Student\SubmissionController as StudentSubmissionController;
use App\Http\Controllers\Lecturer\AssignmentController as LecturerAssignmentController;
use App\Http\Controllers\Lecturer\QuizController as LecturerQuizController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;

Route::get('/', function () {
    return redirect()->route('login');
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
            case 'lecturer':
                return redirect()->route('lecturer.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            default:
                return view('dashboard');
        }
    })->name('dashboard');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('courses', AdminCourseController::class);
        Route::resource('users', AdminUserController::class);
        Route::post('users/import', [AdminUserController::class, 'import'])->name('users.import');
    });

    // Lecturer Routes
    Route::prefix('lecturer')->name('lecturer.')->middleware('role:lecturer')->group(function () {
        Route::get('dashboard', [LecturerDashboardController::class, 'index'])->name('dashboard');

        Route::get('courses/my-courses', [LecturerCourseController::class, 'myCourses'])->name('courses.myCourses');
        Route::get('courses/all-courses', [LecturerCourseController::class, 'allAvailableCourses'])->name('courses.allAvailableCourses');
        Route::get('courses/{course}/show', [LecturerCourseController::class, 'showMyCourse'])->name('courses.showMyCourse');
        Route::get('courses/{course}/detail', [LecturerCourseController::class, 'showCourseDetail'])->name('courses.showCourseDetail');

        Route::post('courses/{course}/sections', [LecturerCourseController::class, 'addSection'])->name('courses.addSection');
        Route::get('courses/{course}/sections/{section}/edit', [LecturerCourseController::class, 'editSection'])->name('courses.editSection');
        Route::put('courses/{course}/sections/{section}', [LecturerCourseController::class, 'updateSection'])->name('courses.updateSection');
        Route::delete('courses/{course}/sections/{section}', [LecturerCourseController::class, 'deleteSection'])->name('courses.deleteSection');

        Route::resource('sections.materials', LecturerMaterialController::class);
        Route::resource('sections.assignments', LecturerAssignmentController::class);
        Route::get('sections/{section}/assignments/{assignment}/submissions', [LecturerAssignmentController::class, 'showSubmissions'])->name('sections.assignments.submissions');
        Route::post('submissions/{submission}/grade', [LecturerAssignmentController::class, 'grade'])->name('submissions.grade');

        Route::get('grades', [LecturerGradeController::class, 'index'])->name('grades.index');
        Route::resource('sections.quizzes', LecturerQuizController::class);
    });

    // Student Routes
    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        Route::resource('courses', StudentCourseController::class)->only(['index', 'show']);
        Route::get('courses/{course}/detail', [StudentCourseController::class, 'detail'])->name('courses.detail');
        Route::get('enrolled-courses', [StudentCourseController::class, 'enrolled'])->name('courses.enrolled');
        Route::post('courses/{course}/enroll', [StudentCourseController::class, 'enroll'])->name('courses.enroll');
        Route::delete('courses/{course}/unenroll', [StudentCourseController::class, 'unenroll'])->name('courses.unenroll');

        Route::get('sections/{section}/materials/{material}', [StudentMaterialController::class, 'show'])->name('materials.show');
        Route::get('sections/{section}/assignments/{assignment}', [StudentAssignmentController::class, 'show'])->name('assignments.show');

        Route::get('assignments/{assignment}/submit', [StudentSubmissionController::class, 'create'])->name('assignments.submit.create');
        Route::post('assignments/{assignment}/submit', [StudentSubmissionController::class, 'store'])->name('assignments.submit');
        Route::get('submissions/{submission}/edit', [StudentSubmissionController::class, 'edit'])->name('submissions.edit');
        Route::put('submissions/{submission}/update', [StudentSubmissionController::class, 'update'])->name('submissions.update');

        Route::get('grades', [StudentGradeController::class, 'index'])->name('grades.index');

        Route::get('quizzes', [StudentQuizController::class, 'index'])->name('quizzes.index');
        Route::get('quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
        Route::post('quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');
        Route::get('quizzes/{quiz}/result', [StudentQuizController::class, 'result'])->name('quizzes.result');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
