<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(CourseSection $section)
    {
        $materials = Material::where('section_id', $section->id)->get();
        return view('teacher.materials.index', compact('section', 'materials'));
    }

    public function create(CourseSection $section)
    {
        return view('teacher.materials.create', compact('section'));
    }

    public function store(Request $request, CourseSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
        ]);

        $filePath = $request->file('file') ? $request->file('file')->store('materials', 'public') : null;

        Material::create([
            'section_id' => $section->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->route('teacher.sections.materials.index', $section)->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(CourseSection $section, Material $material)
    {
        return view('teacher.materials.edit', compact('section', 'material'));
    }

    public function update(Request $request, CourseSection $section, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
        ]);

        if ($request->file('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
            $material->file_path = $filePath;
        }

        $material->title = $request->title;
        $material->description = $request->description;
        $material->save();

        return redirect()->route('teacher.sections.materials.index', $section)->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(CourseSection $section, Material $material)
    {
        $material->delete();
        return redirect()->route('teacher.sections.materials.index', $section)->with('success', 'Materi berhasil dihapus.');
    }
}
