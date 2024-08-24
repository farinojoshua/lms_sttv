@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Course Details: {{ $course->name }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right p-0 bg-transparent breadcrumb">
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

    <div class="mb-4 border-0 rounded-lg shadow-sm card">
        <div class="card-body">
            <h5 class="card-title">{{ $course->name }}</h5>
            <p class="card-text text-muted">{{ $course->description }}</p>
            <p class="card-text"><strong>Lecturer:</strong> {{ $course->lecturer->name }}</p>

            <!-- Button to enroll or unenroll -->
            @if ($course->enrollments->contains('student_id', Auth::id()))
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#unenrollModal">
                    Unenroll
                </button>
            @else
                <form action="{{ route('student.courses.enroll', $course->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Enroll</button>
                </form>
            @endif
        </div>
    </div>

    <div class="mb-4 accordion" id="courseSectionsAccordion">
        @foreach ($sections as $section)
            <div class="mb-3 border-0 rounded-lg shadow-sm card">
                <div class="p-0 card-header bg-light text-primary rounded-top" id="heading{{ $section->id }}">
                    <h2 class="mb-0">
                        <button class="p-3 text-left btn btn-link btn-block d-flex justify-content-between align-items-center" type="button"
                            data-toggle="collapse" data-target="#collapse{{ $section->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $section->id }}">
                            <span>{{ $section->name }}</span>
                            <i class="fa fa-chevron-down transition-icon"></i>
                        </button>
                    </h2>
                </div>

                <div id="collapse{{ $section->id }}" class="collapse" aria-labelledby="heading{{ $section->id }}" data-parent="#courseSectionsAccordion">
                    <div class="card-body">
                        <p class="text-muted">{{ $section->description }}</p>

                        <h6 class="font-weight-bold text-dark">Learning Materials</h6>
                        @if ($section->materials->isEmpty())
                            <p class="text-muted">No learning materials.</p>
                        @else
                            <ul class="mb-3 list-group">
                                @foreach ($section->materials as $material)
                                    <li class="px-0 border-0 list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mr-2 fa fa-file text-primary"></i>
                                            <span class="text-dark">{{ $material->title }}</span>
                                        </div>
                                        @if ($course->enrollments->contains('student_id', Auth::id()))
                                            <a href="{{ route('student.materials.show', [$section->id, $material->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-file"></i> View Material
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-outline-secondary disabled">
                                                <i class="fa fa-lock"></i> Enroll to access
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <h6 class="font-weight-bold text-dark">Assignments</h6>
                        @if ($section->assignments->isEmpty())
                            <p class="text-muted">No assignments.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($section->assignments as $assignment)
                                    <li class="px-0 border-0 list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mr-2 fa fa-tasks text-primary"></i>
                                            <span class="text-dark">{{ $assignment->title }}</span>
                                        </div>
                                        @if ($course->enrollments->contains('student_id', Auth::id()))
                                            <a href="{{ route('student.assignments.show', [$section->id, $assignment->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-tasks"></i> View Assignment
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-outline-secondary disabled">
                                                <i class="fa fa-lock"></i> Enroll to access
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <h6 class="font-weight-bold text-dark">Quizzes</h6>
                        @if ($section->quizzes->isEmpty())
                            <p class="text-muted">No quizzes available.</p>
                        @else
                            <ul class="mb-3 list-group">
                                @foreach ($section->quizzes as $quiz)
                                    <li class="px-0 border-0 list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="mr-2 fa fa-question-circle text-primary"></i>
                                            <span class="text-dark">{{ $quiz->title }}</span>
                                        </div>
                                        @if ($course->enrollments->contains('student_id', Auth::id()))
                                            <a href="{{ route('student.quizzes.show', [$quiz->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-question-circle"></i> View Quiz
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-outline-secondary disabled">
                                                <i class="fa fa-lock"></i> Enroll to access
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Unenroll Modal -->
    <div class="modal fade" id="unenrollModal" tabindex="-1" role="dialog" aria-labelledby="unenrollModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unenrollModalLabel">Unenroll from Course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to unenroll from this course?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('student.courses.unenroll', $course->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Unenroll</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Unenroll Modal -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle arrow direction on collapse
            $('.collapse').on('show.bs.collapse', function() {
                $(this).parent().find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }).on('hide.bs.collapse', function() {
                $(this).parent().find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            });

            // Add smooth transition to icon
            $('.transition-icon').css('transition', 'transform 0.3s ease');
        });
    </script>
@endpush
