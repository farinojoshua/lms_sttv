@extends('layouts.app')

@section('title', 'Nilai Saya')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Nilai Saya</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item active">Nilai Saya</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Rekapan Nilai</h4>
                    <div class="table-responsive">
                        <table id="grades-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mata Kuliah</th>
                                    <th>Bagian</th>
                                    <th>Tugas</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $submission)
                                    <tr>
                                        <td>{{ $submission->assignment->section->course->name }}</td>
                                        <td>{{ $submission->assignment->section->name }}</td>
                                        <td>{{ $submission->assignment->title }}</td>
                                        <td>{{ $submission->grade }}</td>
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
