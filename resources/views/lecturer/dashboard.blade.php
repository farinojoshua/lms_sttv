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
    <!-- Recent Courses -->
    <div class="mb-4 col-lg-4 col-md-6">
        <div class="border-0 rounded-lg shadow-sm card">
            <div class="card-body">
                <h5 class="card-title text-dark font-weight-bold">
                    <i class="mr-2 fa fa-book text-primary"></i>Recent Courses
                </h5>
                <ul class="list-group list-group-flush">
                    @foreach ($recentCourses as $course)
                        <li class="px-0 py-2 border-0 list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('lecturer.courses.showMyCourse', $course->id) }}" class="text-dark font-weight-normal hover-primary">
                                {{ $course->name }}
                            </a>
                            <span class="badge badge-primary badge-pill">{{ $course->semester }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Upcoming Assignments -->
    <div class="mb-4 col-lg-4 col-md-6">
        <div class="border-0 rounded-lg shadow-sm card">
            <div class="card-body">
                <h5 class="card-title text-dark font-weight-bold">
                    <i class="mr-2 fa fa-calendar-alt text-warning"></i>Upcoming Assignments
                </h5>
                <ul class="list-group list-group-flush">
                    @foreach ($upcomingAssignments as $assignment)
                        <li class="px-0 py-2 border-0 list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('lecturer.sections.assignments.index', $assignment->section_id) }}" class="text-dark font-weight-normal hover-primary">
                                {{ $assignment->title }}
                            </a>
                            <small class="text-muted">Due: {{ $assignment->due_date->format('d M Y') }}</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="mb-4 col-lg-4 col-md-6">
        <div class="border-0 rounded-lg shadow-sm card">
            <div class="card-body">
                <h5 class="card-title text-dark font-weight-bold">
                    <i class="mr-2 fa fa-check-circle text-success"></i>Recent Submissions
                </h5>
                <ul class="list-group list-group-flush">
                    @foreach ($recentSubmissions as $submission)
                        <li class="px-0 py-2 border-0 list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('lecturer.sections.assignments.submissions', [$submission->assignment->section_id, $submission->assignment->id]) }}" class="text-dark font-weight-normal hover-primary">
                                {{ $submission->student->name }} - {{ $submission->assignment->title }}
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Smooth hover effects
        $('.hover-primary').hover(
            function() {
                $(this).css({
                    'color': '#007bff',
                    'transition': 'color 0.3s ease'
                });
            }, function() {
                $(this).css({
                    'color': '#212529'
                });
            }
        );
    });
</script>
@endpush
