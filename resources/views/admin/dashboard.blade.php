@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Dashboard Admin</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Total Pengguna</h5>
                    <h3 class="card-text">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Admins -->
        <div class="col-md-4">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa fa-user-shield fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Total Admin</h5>
                    <h3 class="card-text">{{ $totalAdmins }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Teachers -->
        <div class="col-md-4">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa fa-chalkboard-teacher fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Total Dosen</h5>
                    <h3 class="card-text">{{ $totalTeachers }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Students -->
        <div class="col-md-4">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa fa-user-graduate fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Total Mahasiswa</h5>
                    <h3 class="card-text">{{ $totalStudents }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Courses -->
        <div class="col-md-4">
            <div class="card m-b-30 shadow-sm">
                <div class="card-body text-center">
                    <i class="fa fa-book fa-3x text-danger mb-3"></i>
                    <h5 class="card-title">Total Kursus</h5>
                    <h3 class="card-text">{{ $totalCourses }}</h3>
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
