@extends('layouts.app')

@section('title', 'Learning Material Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Learning Material Details: {{ $material->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $section->course_id) }}">Course Details</a></li>
                    <li class="breadcrumb-item active">Learning Material Details</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="mb-4 card">
        <div class="card-body">
            <h4 class="card-title">{{ $material->title }}</h4>
            <p class="card-text">{{ $material->description }}</p>
            @if ($material->file_path)
                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-primary">View File</a>
            @else
                <p>No attached file.</p>
            @endif
        </div>
    </div>
@endsection
