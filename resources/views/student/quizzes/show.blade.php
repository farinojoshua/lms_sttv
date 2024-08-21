@extends('layouts.app')

@section('title', 'Quiz Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Quiz Details: {{ $quiz->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $quiz->section->course_id) }}">Course Details</a></li>
                    <li class="breadcrumb-item active">Quiz Details</li>
                </ol>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="mb-4 card">
        <div class="card-body">
            <h4 class="card-title">{{ $quiz->title }}</h4>
            <p class="card-text">{{ $quiz->description }}</p>
            <p>Start Time: {{ $quiz->start_time->format('Y-m-d H:i') }} ({{ $quiz->start_time->diffForHumans() }})</p>
            <p>End Time: {{ $quiz->end_time->format('Y-m-d H:i') }} ({{ $quiz->end_time->diffForHumans() }})</p>

            @php
                $submission = $quiz->submissions->where('student_id', Auth::id())->first();
                $now = now();
            @endphp

            @if ($submission)
                <div class="mt-3 submission-status">
                    <h6>Submission Status</h6>
                    <p>Score: {{ $submission->score }}%</p>
                    <a href="{{ route('student.quizzes.result', $quiz->id) }}" class="btn btn-primary">View Result</a>
                </div>
            @else
                @if ($now->between($quiz->start_time, $quiz->end_time))
                    <a href="{{ route('student.quizzes.take', $quiz->id) }}" class="btn btn-success">Take Quiz</a>
                @elseif ($now->lt($quiz->start_time))
                    <p class="text-info">This quiz is not yet available. It will start on {{ $quiz->start_time->format('Y-m-d H:i') }}.</p>
                @else
                    <p class="text-danger">The quiz submission deadline has passed.</p>
                @endif
            @endif
        </div>
    </div>
@endsection
