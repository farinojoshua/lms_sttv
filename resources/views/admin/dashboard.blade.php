@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Users -->
        <div class="col-md-4">
            <div class="shadow-sm card m-b-30">
                <div class="text-center card-body">
                    <i class="mb-3 fa fa-users fa-3x text-primary"></i>
                    <h5 class="card-title">Total Users</h5>
                    <h3 class="card-text">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Admins -->
        <div class="col-md-4">
            <div class="shadow-sm card m-b-30">
                <div class="text-center card-body">
                    <i class="mb-3 fa fa-user-shield fa-3x text-warning"></i>
                    <h5 class="card-title">Total Admins</h5>
                    <h3 class="card-text">{{ $totalAdmins }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Lecturers -->
        <div class="col-md-4">
            <div class="shadow-sm card m-b-30">
                <div class="text-center card-body">
                    <i class="mb-3 fa fa-chalkboard-lecturer fa-3x text-success"></i>
                    <h5 class="card-title">Total Lecturers</h5>
                    <h3 class="card-text">{{ $totalLecturers }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Students -->
        <div class="col-md-4">
            <div class="shadow-sm card m-b-30">
                <div class="text-center card-body">
                    <i class="mb-3 fa fa-user-graduate fa-3x text-info"></i>
                    <h5 class="card-title">Total Students</h5>
                    <h3 class="card-text">{{ $totalStudents }}</h3>
                </div>
            </div>
        </div>
        <!-- Total Courses -->
        <div class="col-md-4">
            <div class="shadow-sm card m-b-30">
                <div class="text-center card-body">
                    <i class="mb-3 fa fa-book fa-3x text-danger"></i>
                    <h5 class="card-title">Total Courses</h5>
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
