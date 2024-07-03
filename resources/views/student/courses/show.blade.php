@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Course Details: {{ $course->name }}</h4>
            </div>
            <div class="col-sm-6">
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

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="mb-4 card">
        <div class="card-body">
            <h4 class="card-title">{{ $course->name }}</h4>
            <p class="card-text">{{ $course->description }}</p>
            <p class="card-text"><strong>Lecturer:</strong> {{ $course->lecturer->name }}</p>

            <!-- Button to trigger unenroll modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#unenrollModal">
                Unenroll
            </button>

            <!-- Unenroll Modal -->
            <div class="modal fade" id="unenrollModal" tabindex="-1" role="dialog" aria-labelledby="unenrollModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="unenrollModalLabel">Unenroll</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('student.courses.unenroll', $course->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <p>Are you sure you want to unenroll from this course?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Unenroll</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Unenroll Modal -->
        </div>
    </div>

    <div class="accordion" id="courseSectionsAccordion">
        @foreach ($sections as $section)
            <div class="card">
                <div class="card-header" id="heading{{ $section->id }}">
                    <h2 class="mb-0 d-flex justify-content-between align-items-center">
                        <button class="text-left btn btn-link btn-block section-header" type="button"
                            data-toggle="collapse" data-target="#collapse{{ $section->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $section->id }}">
                            {{ $section->name }}
                        </button>
                        <i class="fa fa-chevron-down"></i>
                    </h2>
                </div>

                <div id="collapse{{ $section->id }}" class="collapse" aria-labelledby="heading{{ $section->id }}"
                    data-parent="#courseSectionsAccordion">
                    <div class="card-body">
                        <p>{{ $section->description }}</p>

                        <h6 class="font-weight-bold">Learning Materials</h6>
                        @if ($section->materials->isEmpty())
                            <p>No learning materials.</p>
                        @else
                            <ul class="mb-3 list-group">
                                @foreach ($section->materials as $material)
                                    <li class="list-group-item">
                                        <a href="{{ route('student.materials.show', ['section' => $section->id, 'material' => $material->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-file"></i> {{ $material->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <h6 class="font-weight-bold">Assignments</h6>
                        @if ($section->assignments->isEmpty())
                            <p>No assignments.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($section->assignments as $assignment)
                                    <li class="list-group-item">
                                        <a href="{{ route('student.assignments.show', ['section' => $section->id, 'assignment' => $assignment->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-tasks"></i> {{ $assignment->title }}
                                        </a>
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
            $('#datatable').DataTable();
        });

        // Toggle arrow direction on collapse
        $('.collapse').on('show.bs.collapse', function() {
            $(this).parent().find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }).on('hide.bs.collapse', function() {
            $(this).parent().find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        });
    </script>
@endpush
