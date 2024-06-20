<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\CourseSection;

class AssignmentController extends Controller
{
    public function show($sectionId, Assignment $assignment)
    {
        $section = CourseSection::findOrFail($sectionId);
        return view('student.assignments.show', compact('assignment', 'section'));
    }
}
