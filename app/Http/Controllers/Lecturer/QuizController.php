<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\CourseSection;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(CourseSection $section)
    {
        $quizzes = $section->quizzes;
        return view('lecturer.quizzes.index', compact('section', 'quizzes'));
    }

    public function create(CourseSection $section)
    {
        return view('lecturer.quizzes.create', compact('section'));
    }

    public function store(Request $request, CourseSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:Y-m-d\TH:i',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:start_time',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $quiz = $section->quizzes()->create($request->only('title', 'description', 'start_time', 'end_time'));

        foreach ($request->questions as $questionData) {
            $quiz->questions()->create($questionData);
        }

        return redirect()->route('lecturer.sections.quizzes.index', $section)->with('success', 'Quiz and questions have been created successfully.');
    }

    public function edit(CourseSection $section, Quiz $quiz)
    {
        return view('lecturer.quizzes.edit', compact('section', 'quiz'));
    }

    public function update(Request $request, CourseSection $section, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:Y-m-d\TH:i',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:start_time',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $quiz->update($request->only('title', 'description', 'start_time', 'end_time'));

        foreach ($request->questions as $index => $questionData) {
            $quiz->questions[$index]->update($questionData);
        }

        return redirect()->route('lecturer.sections.quizzes.index', $section)->with('success', 'Quiz and questions have been updated successfully.');
    }

    public function destroy(CourseSection $section, Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('lecturer.sections.quizzes.index', $section)->with('success', 'Quiz has been deleted.');
    }
}
