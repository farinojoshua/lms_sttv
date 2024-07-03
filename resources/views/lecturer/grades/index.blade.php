@extends('layouts.app')

@section('title', 'Student Grades')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Student Grades</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item active">Student Grades</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($courses as $course)
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $course->name }}</h4>
                        <div class="table-responsive">
                            <table id="grades-table-{{ $course->id }}" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Assignment</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->sections as $section)
                                        @foreach ($section->assignments as $assignment)
                                            @foreach ($assignment->submissions as $submission)
                                                <tr>
                                                    <td>{{ $submission->student->name }}</td>
                                                    <td>{{ $assignment->title }}</td>
                                                    <td>{{ $submission->grade }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            @foreach ($courses as $course)
                $('#grades-table-{{ $course->id }}').DataTable();
            @endforeach
        });
    </script>
@endpush
