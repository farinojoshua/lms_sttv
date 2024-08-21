@extends('layouts.app')

@section('title', 'Quiz Result')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Quiz Result: {{ $quiz->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $quiz->section->course_id) }}">Course Details</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.quizzes.show', $quiz->id) }}">Quiz Details</a></li>
                    <li class="breadcrumb-item active">Quiz Result</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="mb-4 card-title">{{ $quiz->title }} - Result</h4>
            <p>Score: {{ $submission->score }}%</p>

            @foreach($quiz->questions as $index => $question)
                <div class="mb-4">
                    <h5>Question {{ $index + 1 }}: {{ $question->question }}</h5>
                    @foreach($question->options as $optionIndex => $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" disabled
                                {{ $submission->answers->where('question_id', $question->id)->first()->selected_answer == $optionIndex ? 'checked' : '' }}
                                {{ $question->correct_answer == $optionIndex ? 'data-correct="true"' : '' }}>
                            <label class="form-check-label {{ $question->correct_answer == $optionIndex ? 'text-success' : '' }}">
                                {{ $option }}
                                @if($question->correct_answer == $optionIndex)
                                    <i class="fa fa-check text-success"></i>
                                @endif
                            </label>
                        </div>
                    @endforeach
                    @if($submission->answers->where('question_id', $question->id)->first()->is_correct)
                        <p class="text-success">Correct</p>
                    @else
                        <p class="text-danger">Incorrect</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
<style>
    .form-check-input[data-correct="true"] {
        border-color: #28a745;
    }
</style>
@endpush
