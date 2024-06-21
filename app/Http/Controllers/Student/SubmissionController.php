<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function create(Assignment $assignment)
    {
        return view('student.assignments.create', compact('assignment'));
    }

    public function store(Request $request, Assignment $assignment)
    {
        if (now()->greaterThan($assignment->due_date)) {
            return redirect()->route('student.assignments.show', [$assignment->section->id, $assignment->id])
                ->with('error', 'Batas waktu pengumpulan tugas telah lewat.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:10240',
        ]);

        $filePath = $request->file('file')->store('submissions', 'public');

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => Auth::id(),
            'file_path' => $filePath,
        ]);

        return redirect()->route('student.assignments.show', [$assignment->section->id, $assignment->id])
            ->with('success', 'Tugas berhasil dikumpulkan.');
    }

    public function edit(Submission $submission)
    {
        return view('student.assignments.edit', compact('submission'));
    }

    public function update(Request $request, Submission $submission)
    {
        if (now()->greaterThan($submission->assignment->due_date)) {
            return redirect()->route('student.assignments.show', [$submission->assignment->section->id, $submission->assignment->id])
                ->with('error', 'Batas waktu pengumpulan tugas telah lewat.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx',
        ]);

        $filePath = $request->file('file')->store('submissions', 'public');

        $submission->update([
            'file_path' => $filePath,
        ]);

        return redirect()->route('student.assignments.show', [$submission->assignment->section->id, $submission->assignment->id])
            ->with('success', 'Tugas berhasil diperbarui.');
    }
}
