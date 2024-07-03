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

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    @if (now()->lessThan($assignment->due_date))
                        <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="file" class="col-sm-2 col-form-label">Assignment File</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            The assignment submission deadline has passed. You cannot submit the assignment anymore.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
