@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Edit Tugas</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('teacher.sections.assignments.index', $section) }}">Tugas</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form
                        action="{{ route('teacher.sections.assignments.update', ['section' => $section, 'assignment' => $assignment]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Judul Tugas</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $assignment->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $assignment->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Batas Waktu</label>
                            <input type="datetime-local" class="form-control" id="due_date" name="due_date"
                                value="{{ $assignment->due_date->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control" id="file" name="file">
                            @if ($assignment->file_path)
                                <p>File saat ini: <a href="{{ asset('storage/' . $assignment->file_path) }}"
                                        target="_blank">Lihat File</a></p>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
