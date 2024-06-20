@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Detail Tugas: {{ $assignment->title }}</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.show', $section->course_id) }}">Detail Mata
                            Kuliah</a></li>
                    <li class="breadcrumb-item active">Detail Tugas</li>
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

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">{{ $assignment->title }}</h4>
            <p class="card-text">{{ $assignment->description }}</p>
            <p>Batas Waktu: {{ $assignment->due_date->format('Y-m-d H:i') }} ({{ $assignment->due_date->diffForHumans() }})
            </p>
            @if ($assignment->file_path)
                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-primary">Lihat
                    File</a>
            @else
                <p>Tidak ada file terlampir.</p>
            @endif

            @php
                $submission = $assignment->submissions->where('student_id', Auth::id())->first();
            @endphp

            @if ($submission)
                <div class="submission-status mt-3">
                    <h6>Status Pengumpulan</h6>
                    <p>File yang dikumpulkan: <a href="{{ asset('storage/' . $submission->file_path) }}"
                            target="_blank">Lihat File</a></p>
                    <p>Nilai: {{ $submission->grade ?? 'Belum dinilai' }}</p>
                    <p>Feedback: {{ $submission->feedback ?? 'Belum ada feedback' }}</p>

                    <a href="{{ route('student.submissions.edit', $submission->id) }}" class="btn btn-success btn-sm">Ubah
                        Tugas</a>
                </div>
            @else
                @if ($assignment->due_date > now())
                    <a href="{{ route('student.assignments.submit.create', $assignment->id) }}"
                        class="btn btn-success btn-sm">Kumpulkan Tugas</a>
                @else
                    <p class="text-danger">Batas waktu pengumpulan tugas telah lewat.</p>
                @endif
            @endif
        </div>
    </div>
@endsection
