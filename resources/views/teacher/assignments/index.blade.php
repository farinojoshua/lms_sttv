@extends('layouts.app')

@section('title', 'Tugas')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Tugas</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teacher.courses.show', $section->course_id) }}">Detail Mata
                            Kuliah</a></li>
                    <li class="breadcrumb-item active">Tugas</li>
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

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="{{ route('teacher.sections.assignments.create', $section->id) }}"
                        class="btn btn-primary mb-3">Tambah Tugas</a>
                    <table class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Batas Waktu</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->title }}</td>
                                    <td>{{ $assignment->description }}</td>
                                    <td>{{ $assignment->due_date->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if ($assignment->file_path)
                                            <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank">Lihat
                                                File</a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.sections.assignments.edit', ['section' => $section->id, 'assignment' => $assignment->id]) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Button trigger delete modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteAssignmentModal{{ $assignment->id }}">Hapus</button>
                                        <a href="{{ route('teacher.sections.assignments.submissions', ['section' => $section->id, 'assignment' => $assignment->id]) }}"
                                            class="btn btn-info btn-sm">Lihat Submission</a>
                                    </td>
                                </tr>

                                <!-- Delete Assignment Modal -->
                                <div class="modal fade" id="deleteAssignmentModal{{ $assignment->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteAssignmentModalLabel{{ $assignment->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteAssignmentModalLabel{{ $assignment->id }}">Hapus Tugas</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus tugas ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form
                                                    action="{{ route('teacher.sections.assignments.destroy', ['section' => $section->id, 'assignment' => $assignment->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Assignment Modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endpush
