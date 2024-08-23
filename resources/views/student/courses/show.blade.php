@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-6">
                <h4 class="page-title">Course Details: {{ $course->name }}</h4>
            </div>
            <div class="col-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.enrolled') }}">Enrolled Courses</a></li>
                    <li class="breadcrumb-item active">Course Details</li>
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

    <div class="mb-4 shadow-sm card">
        <div class="card-body">
            <h4 class="card-title">{{ $course->name }}</h4>
            <p class="card-text">{{ $course->description }}</p>
            <p class="card-text"><strong>Lecturer:</strong> {{ $course->lecturer->name }}</p>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#unenrollModal">Unenroll</button>
        </div>
    </div>

    <div class="mb-4 accordion" id="courseSectionsAccordion">
        @foreach ($sections as $section)
            <div class="card">
                <div class="card-header" id="heading{{ $section->id }}">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $section->id }}" aria-expanded="true" aria-controls="collapse{{ $section->id }}">
                            {{ $section->name }} <i class="ml-2 fa fa-chevron-down"></i>
                        </button>
                    </h2>
                </div>

                <div id="collapse{{ $section->id }}" class="collapse" aria-labelledby="heading{{ $section->id }}" data-parent="#courseSectionsAccordion">
                    <div class="card-body">
                        <p>{{ $section->description }}</p>
                        <!-- Add rest of the content here -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
