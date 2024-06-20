@extends('layouts.app')

@section('title', 'Detail Mata Kuliah')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Detail Mata Kuliah</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teacher.courses.index') }}">Daftar Mata Kuliah</a></li>
                    <li class="breadcrumb-item active">Detail Mata Kuliah</li>
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
                    <h4 class="card-title">{{ $course->name }}</h4>
                    <p class="card-text">{{ $course->description }}</p>

                    <h5>Mahasiswa yang Terdaftar</h5>
                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#studentsModal">
                        Lihat Mahasiswa yang Terdaftar
                    </button>

                    <!-- Students Modal -->
                    <div class="modal fade" id="studentsModal" tabindex="-1" role="dialog"
                        aria-labelledby="studentsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="studentsModalLabel">Mahasiswa yang Terdaftar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table id="students-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($enrollments as $enrollment)
                                                    <tr>
                                                        <td>{{ $enrollment->student->name }}</td>
                                                        <td>{{ $enrollment->student->email }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Students Modal -->

                    <h5>Bagian Kursus</h5>
                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSectionModal">
                        Tambah Bagian Kursus
                    </button>
                    <table id="sections-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Materi</th>
                                <th>Tugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sections as $section)
                                <tr>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $section->description }}</td>
                                    <td>
                                        <a href="{{ route('teacher.sections.materials.index', $section->id) }}"
                                            class="btn btn-info btn-sm">Materi Pembelajaran</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.sections.assignments.index', $section->id) }}"
                                            class="btn btn-info btn-sm">Tugas</a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#editSectionModal{{ $section->id }}">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteSectionModal{{ $section->id }}">Delete</button>
                                    </td>
                                </tr>

                                <!-- Edit Section Modal -->
                                <div class="modal fade" id="editSectionModal{{ $section->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="editSectionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editSectionModalLabel">Edit Bagian Kursus</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form
                                                action="{{ route('teacher.courses.updateSection', ['course' => $course->id, 'section' => $section->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Nama Bagian</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $section->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Deskripsi</label>
                                                        <textarea class="form-control" id="description" name="description" rows="3">{{ $section->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Edit Section Modal -->

                                <!-- Delete Section Modal -->
                                <div class="modal fade" id="deleteSectionModal{{ $section->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteSectionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteSectionModalLabel">Hapus Bagian Kursus
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form
                                                action="{{ route('teacher.courses.deleteSection', ['course' => $course->id, 'section' => $section->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus bagian kursus ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Section Modal -->
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Add Section Modal -->
                    <div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog"
                        aria-labelledby="addSectionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addSectionModalLabel">Tambah Bagian Kursus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('teacher.courses.addSection', $course) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">Nama Bagian</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Section Modal -->

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#students-table').DataTable();
            $('#sections-table').DataTable();
        });
    </script>
@endpush
