@extends('layouts.app')

@section('title', 'Material Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Material: {{ $material->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.courses.showCourseDetail', $section->id) }}">Course Detail</a></li>
                    <li class="breadcrumb-item active">Material Details</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="card-title">{{ $material->title }}</h4>
            <p>{{ $material->description }}</p>

            @if($material->file_path)
                <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-primary" download>Download Material</a>
            @endif
        </div>
    </div>
@endsection
