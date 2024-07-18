<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(CourseSection $section)
    {
        $materials = Material::where('section_id', $section->id)->get();
        return view('lecturer.materials.index', compact('section', 'materials'));
    }

    public function create(CourseSection $section)
    {
        return view('lecturer.materials.create', compact('section'));
    }

    public function store(Request $request, CourseSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,ppt,pptx,mp4,avi,mp3,wav,jpg,jpeg,png|max:10240',
        ]);

        $filePath = $request->file('file') ? $request->file('file')->store('materials', 'public') : null;

        Material::create([
            'section_id' => $section->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        return redirect()->route('lecturer.sections.materials.index', $section)->with('success', 'Learning material has been created.');
    }

    public function edit(CourseSection $section, Material $material)
    {
        return view('lecturer.materials.edit', compact('section', 'material'));
    }

    public function update(Request $request, CourseSection $section, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,ppt,pptx,mp4,avi,mp3,wav,jpg,jpeg,png|max:10240',
        ]);

        if ($request->file('file')) {
            $filePath = $request->file('file')->store('materials', 'public');
            $material->file_path = $filePath;
        }

        $material->title = $request->title;
        $material->description = $request->description;
        $material->save();

        return redirect()->route('lecturer.sections.materials.index', $section)->with('success', 'Learning material has been updated.');
    }

    public function destroy(CourseSection $section, Material $material)
    {
        $material->delete();
        return redirect()->route('lecturer.sections.materials.index', $section)->with('success', 'Learning material has been deleted.');
    }
}
