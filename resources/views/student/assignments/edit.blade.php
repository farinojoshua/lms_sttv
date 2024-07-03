@extends('layouts.app')

@section('title', 'Edit Submission')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Edit Submission: {{ $submission->assignment->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $submission->assignment->section->course_id) }}">Course Details</a></li>
                    <li class="breadcrumb-item active">Edit Submission</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="mb-4 card">
        <div class="card-body">
            @if (now()->lessThan($submission->assignment->due_date))
                <form action="{{ route('student.submissions.update', $submission->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Assignment File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            @else
                <div class="alert alert-danger">
                    The assignment submission deadline has passed. You cannot update the submission anymore.
                </div>
            @endif
        </div>
    </div>
@endsection
