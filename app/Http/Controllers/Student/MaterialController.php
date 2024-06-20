<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\CourseSection;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function show($sectionId, Material $material)
    {
        $section = CourseSection::findOrFail($sectionId);
        return view('student.materials.show', compact('material', 'section'));
    }
}
