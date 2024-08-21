@extends('layouts.app')

@section('title', 'My Grades')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">My Grades</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item active">My Grades</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Grade Summary</h4>
                    <div class="table-responsive">
                        <table id="grades-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Item</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignmentSubmissions as $submission)
                                    <tr>
                                        <td>{{ $submission->assignment->section->course->name }}</td>
                                        <td>{{ $submission->assignment->section->name }}</td>
                                        <td>{{ $submission->assignment->title }} (Assignment)</td>
                                        <td>{{ $submission->grade }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($quizSubmissions as $submission)
                                    <tr>
                                        <td>{{ $submission->quiz->section->course->name }}</td>
                                        <td>{{ $submission->quiz->section->name }}</td>
                                        <td>{{ $submission->quiz->title }} (Quiz)</td>
                                        <td>{{ $submission->score }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#grades-table').DataTable();
        });
    </script>
@endpush
