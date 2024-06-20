@extends('layouts.app')

@section('title', 'Materi Pembelajaran')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Materi Pembelajaran</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teacher.courses.show', $section->course_id) }}">Detail Mata
                            Kuliah</a></li>
                    <li class="breadcrumb-item active">Materi Pembelajaran</li>
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
                    <a href="{{ route('teacher.sections.materials.create', $section->id) }}"
                        class="btn btn-primary mb-3">Tambah Materi</a>
                    <table class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->title }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td>
                                        @if ($material->file_path)
                                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank">Lihat
                                                File</a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.sections.materials.edit', ['section' => $section->id, 'material' => $material->id]) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Button trigger delete modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteMaterialModal{{ $material->id }}">Hapus</button>
                                    </td>
                                </tr>

                                <!-- Delete Material Modal -->
                                <div class="modal fade" id="deleteMaterialModal{{ $material->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteMaterialModalLabel{{ $material->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteMaterialModalLabel{{ $material->id }}">
                                                    Hapus Materi</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus materi ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <form
                                                    action="{{ route('teacher.sections.materials.destroy', ['section' => $section->id, 'material' => $material->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Material Modal -->
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
