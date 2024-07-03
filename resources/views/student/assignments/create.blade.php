@extends('layouts.app')

@section('title', 'Submit Assignment')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Submit Assignment: {{ $assignment->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $assignment->section->course_id) }}">Course Details</a></li>
                    <li class="breadcrumb-item active">Submit Assignment</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="mb-4 card">
        <div class="card-body">
            @if (now()->lessThan($assignment->due_date))
                <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Assignment File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            @else
                <div class="alert alert-danger">
                    The assignment submission deadline has passed. You cannot submit the assignment anymore.
                </div>
            @endif
        </div>
    </div>
@endsection
