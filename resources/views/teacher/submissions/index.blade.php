@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Submissions for: {{ $assignment->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teacher.courses.show', $section->course_id) }}">Detail Mata
                            Kuliah</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('teacher.sections.assignments.index', $section->id) }}">Tugas</a></li>
                    <li class="breadcrumb-item active">Submissions</li>
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

    <div class="card mb-4">
        <div class="card-body">
            @if ($submissions->isEmpty())
                <p>Belum ada mahasiswa yang mengumpulkan tugas ini.</p>
            @else
                @foreach ($submissions as $submission)
                    <div class="submission-item">
                        <p><strong>Student:</strong> {{ $submission->student->name }}</p>
                        <p><strong>File:</strong> <a href="{{ asset('storage/' . $submission->file_path) }}"
                                target="_blank">View File</a></p>
                        <p><strong>Grade:</strong> {{ $submission->grade ?? 'Not graded yet' }}</p>
                        <p><strong>Feedback:</strong> {{ $submission->feedback ?? 'No feedback' }}</p>

                        <!-- Button to trigger grade modal -->
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#gradeSubmissionModal{{ $submission->id }}">Grade Submission</button>

                        <!-- Grade Submission Modal -->
                        <div class="modal fade" id="gradeSubmissionModal{{ $submission->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="gradeSubmissionModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="gradeSubmissionModalLabel">Grade Submission:
                                            {{ $assignment->title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('teacher.submissions.grade', $submission->id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="grade">Grade</label>
                                                <input type="number" class="form-control" id="grade" name="grade"
                                                    min="0" max="100" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="feedback">Feedback</label>
                                                <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit Grade</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Grade Submission Modal -->
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
@endsection
