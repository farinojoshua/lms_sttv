@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
    <div class="mb-4 page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title font-weight-bold text-primary">Course Details: {{ $course->name }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right p-0 bg-transparent breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.dashboard') }}" class="text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.courses.allAvailableCourses') }}" class="text-muted">All Courses</a></li>
                    <li class="breadcrumb-item active text-primary">Course Details</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="mb-4 border-0 rounded-lg shadow card">
        <div class="card-body">
            <h5 class="card-title text-primary font-weight-bold">{{ $course->name }}</h5>
            <p class="card-text text-muted">{{ $course->description }}</p>
            <p class="card-text"><strong>Lecturer:</strong> {{ $course->lecturer->name }}</p>
        </div>
    </div>

    <div class="accordion" id="courseSectionsAccordion">
        @foreach ($sections as $section)
            <div class="mb-3 border-0 rounded-lg shadow-sm card">
                <div class="card-header bg-light text-primary rounded-top" id="heading{{ $section->id }}">
                    <h2 class="mb-0 d-flex justify-content-between align-items-center">
                        <button class="p-0 text-left btn btn-link btn-block section-header" type="button"
                            data-toggle="collapse" data-target="#collapse{{ $section->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $section->id }}">
                            {{ $section->name }}
                        </button>
                        <i class="fa fa-chevron-down transition-icon"></i>
                    </h2>
                </div>

                <div id="collapse{{ $section->id }}" class="collapse" aria-labelledby="heading{{ $section->id }}"
                    data-parent="#courseSectionsAccordion">
                    <div class="card-body">
                        <p class="text-muted">{{ $section->description }}</p>

                        <h6 class="font-weight-bold text-dark">Learning Materials</h6>
                        @if ($section->materials->isEmpty())
                            <p class="text-muted">No learning materials.</p>
                        @else
                            <ul class="mb-3 list-group">
                                @foreach ($section->materials as $material)
                                    <li class="px-0 border-0 list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-dark">{{ $material->title }}</span>
                                        @if($material->file_path)
                                            <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-sm btn-outline-primary" download>
                                                <i class="mr-1 fa fa-download"></i>Download
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
                                        <span class="text-dark">{{ $assignment->title }}</span>
                                        @if($assignment->file_path)
                                            <a href="{{ asset('storage/' . $assignment->file_path) }}" class="btn btn-sm btn-outline-primary" download>
                                                <i class="mr-1 fa fa-download"></i>Download
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

            // Add hover effects on buttons
            $('.btn-outline-primary').hover(
                function() {
                    $(this).addClass('btn-primary text-white');
                }, function() {
                    $(this).removeClass('btn-primary text-white');
                }
            );
        });
    </script>
@endpush
