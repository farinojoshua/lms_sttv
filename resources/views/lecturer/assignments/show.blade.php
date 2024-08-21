@extends('layouts.app')

@section('title', 'Assignment Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Assignment: {{ $assignment->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.courses.showCourseDetail', $section->id) }}">Course Detail</a></li>
                    <li class="breadcrumb-item active">Assignment Details</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="card-title">{{ $assignment->title }}</h4>
            <p>{{ $assignment->description }}</p>

            @if($assignment->file_path)
                <a href="{{ asset('storage/' . $assignment->file_path) }}" class="btn btn-primary" download>Download Assignment</a>
            @endif
        </div>
    </div>
@endsection
