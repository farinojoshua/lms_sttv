<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\QuizSubmissionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $studentId = Auth::id();
        $quizzes = Quiz::whereHas('section.course.enrollments', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);
        })->get();

        return view('student.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        $studentId = Auth::id();
        $submission = QuizSubmission::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->first();

        if ($submission) {
            return view('student.quizzes.result', compact('quiz', 'submission'));
        }

        if (Carbon::now()->between($quiz->start_time, $quiz->end_time)) {
            return view('student.quizzes.take', compact('quiz'));
        }

        return view('student.quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $studentId = Auth::id();

        // Check if the quiz is still open
        if (!Carbon::now()->between($quiz->start_time, $quiz->end_time)) {
            return redirect()->route('student.quizzes.show', $quiz)->with('error', 'Quiz is no longer available.');
        }

        // Check if the student has already submitted
        $existingSubmission = QuizSubmission::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->first();

        if ($existingSubmission) {
            return redirect()->route('student.quizzes.show', $quiz)->with('error', 'You have already submitted this quiz.');
        }

        // Create a new submission
        $submission = QuizSubmission::create([
            'quiz_id' => $quiz->id,
            'student_id' => $studentId,
        ]);

        $score = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $selectedAnswer = $request->input('question_' . $question->id);
            $isCorrect = 'option_' . ($selectedAnswer + 1) === $question->correct_answer;

            if ($isCorrect) {
                $score++;
            }

            QuizSubmissionAnswer::create([
                'submission_id' => $submission->id,
                'question_id' => $question->id,
                'selected_answer' => $selectedAnswer,
                'is_correct' => $isCorrect,
            ]);
        }

        $submission->update([
            'score' => ($score / $totalQuestions) * 100,
        ]);

        return redirect()->route('student.quizzes.result', $quiz)->with('success', 'Quiz submitted successfully.');
    }

    public function result(Quiz $quiz)
    {
        $studentId = Auth::id();
        $submission = QuizSubmission::where('quiz_id', $quiz->id)
            ->where('student_id', $studentId)
            ->firstOrFail();

        return view('student.quizzes.result', compact('quiz', 'submission'));
    }
}
