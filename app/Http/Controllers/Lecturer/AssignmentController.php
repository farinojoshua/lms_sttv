<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use App\Models\Submission;

class AssignmentController extends Controller
{
    public function index(CourseSection $section)
    {
        $assignments = Assignment::where('section_id', $section->id)->get();
        return view('lecturer.assignments.index', compact('section', 'assignments'));
    }

    public function create(CourseSection $section)
    {
        return view('lecturer.assignments.create', compact('section'));
    }

    public function store(Request $request, CourseSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date_format:Y-m-d\TH:i',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240',
        ]);

        $filePath = $request->file('file') ? $request->file('file')->store('assignments', 'public') : null;

        Assignment::create([
            'section_id' => $section->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'file_path' => $filePath,
        ]);

        return redirect()->route('lecturer.sections.assignments.index', $section)->with('success', 'Assignment has been created.');
    }

    public function edit(CourseSection $section, Assignment $assignment)
    {
        return view('lecturer.assignments.edit', compact('section', 'assignment'));
    }

    public function update(Request $request, CourseSection $section, Assignment $assignment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date_format:Y-m-d\TH:i',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->file('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
            $assignment->file_path = $filePath;
        }

        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->due_date = $request->due_date;
        $assignment->save();

        return redirect()->route('lecturer.sections.assignments.index', $section)->with('success', 'Assignment has been updated.');
    }

    public function destroy(CourseSection $section, Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('lecturer.sections.assignments.index', $section)->with('success', 'Assignment has been deleted.');
    }

    public function grade(Request $request, Submission $submission)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
        ]);

        // Use the assignment to find the section and course
        $section = $submission->assignment->section;
        return redirect()->route('lecturer.sections.assignments.index', $section->id)->with('success', 'Submission has been graded.');
    }

    public function showSubmissions(CourseSection $section, Assignment $assignment)
    {
        $submissions = $assignment->submissions()->with('student')->get();
        return view('lecturer.submissions.index', compact('section', 'assignment', 'submissions'));
    }
}
