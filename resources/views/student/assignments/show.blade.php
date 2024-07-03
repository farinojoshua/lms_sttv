@extends('layouts.app')

@section('title', 'Assignment Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Assignment Details: {{ $assignment->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $section->course_id) }}">Course Details</a></li>
                    <li class="breadcrumb-item active">Assignment Details</li>
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
            <h4 class="card-title">{{ $assignment->title }}</h4>
            <p class="card-text">{{ $assignment->description }}</p>
            <p>Due Date: {{ $assignment->due_date->format('Y-m-d H:i') }} ({{ $assignment->due_date->diffForHumans() }})</p>
            @if ($assignment->file_path)
                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-primary">View File</a>
            @else
                <p>No attached file.</p>
            @endif

            @php
                $submission = $assignment->submissions->where('student_id', Auth::id())->first();
            @endphp

            @if ($submission)
                <div class="mt-3 submission-status">
                    <h6>Submission Status</h6>
                    <p>Submitted File: <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">View File</a></p>
                    <p>Grade: {{ $submission->grade ?? 'Not graded yet' }}</p>
                    <p>Feedback: {{ $submission->feedback ?? 'No feedback yet' }}</p>

                    <a href="{{ route('student.submissions.edit', $submission->id) }}" class="btn btn-success">Edit Submission</a>
                </div>
            @else
                @if ($assignment->due_date > now())
                    <a href="{{ route('student.assignments.submit.create', $assignment->id) }}" class="btn btn-success">Submit Assignment</a>
                @else
                    <p class="text-danger">The assignment submission deadline has passed.</p>
                @endif
            @endif
        </div>
    </div>
@endsection
