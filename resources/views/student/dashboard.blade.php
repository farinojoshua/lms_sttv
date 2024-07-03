@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Enrolled Courses -->
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Enrolled Courses</h4>
                    <ul class="list-group">
                        @foreach ($enrollments as $enrollment)
                            <li class="list-group-item">
                                <a href="{{ route('student.courses.show', $enrollment->course->id) }}">{{ $enrollment->course->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Upcoming Assignments -->
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Upcoming Assignments</h4>
                    <ul class="list-group">
                        @foreach ($upcomingAssignments as $assignment)
                            <li class="list-group-item">
                                <a href="{{ route('student.assignments.show', [$assignment->section->id, $assignment->id]) }}">{{ $assignment->title }}</a>
                                <small class="text-muted">Due Date: {{ $assignment->due_date->format('d M Y') }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Submissions</h4>
                    <ul class="list-group">
                        @foreach ($recentSubmissions as $submission)
                            <li class="list-group-item">
                                <a href="{{ route('student.assignments.show', [$submission->assignment->section_id, $submission->assignment->id]) }}">
                                    {{ $submission->assignment->title }}
                                </a>
                                <small class="text-muted">{{ $submission->created_at->format('d M Y H:i') }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
