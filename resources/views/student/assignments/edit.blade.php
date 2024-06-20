@extends('layouts.app')

@section('title', 'Ubah Tugas')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Ubah Tugas: {{ $submission->assignment->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('student.courses.show', $submission->assignment->section->course_id) }}">Detail
                            Mata Kuliah</a></li>
                    <li class="breadcrumb-item active">Ubah Tugas</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            @if (now()->lessThan($submission->assignment->due_date))
                <form action="{{ route('student.submissions.update', $submission->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">File Tugas</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </form>
            @else
                <div class="alert alert-danger">
                    Batas waktu pengumpulan tugas telah lewat. Anda tidak dapat mengubah tugas lagi.
                </div>
            @endif
        </div>
    </div>
@endsection
