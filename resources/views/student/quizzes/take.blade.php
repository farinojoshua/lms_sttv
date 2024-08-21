@extends('layouts.app')

@section('title', 'Take Quiz')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Take Quiz: {{ $quiz->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $quiz->section->course_id) }}">Course Details</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.quizzes.show', $quiz->id) }}">Quiz Details</a></li>
                    <li class="breadcrumb-item active">Take Quiz</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="mb-4 card-title">{{ $quiz->title }}</h4>
            <form action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST">
                @csrf
                @foreach($quiz->questions as $index => $question)
                    <div class="mb-4">
                        <h5>Question {{ $index + 1 }}: {{ $question->question }}</h5>
                        @foreach($question->options as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="question_{{ $question->id }}_{{ $loop->index }}" value="{{ $loop->index }}">
                                <label class="form-check-label" for="question_{{ $question->id }}_{{ $loop->index }}">
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Submit Quiz</button>
            </form>
        </div>
    </div>
@endsection
