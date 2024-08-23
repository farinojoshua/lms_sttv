@extends('layouts.app')

@section('title', 'Enrolled Courses')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-6">
                <h4 class="page-title">Enrolled Courses</h4>
            </div>
            <div class="col-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Enrolled Courses</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mb-3 shadow-sm card">
                <div class="card-body">
                    <form method="GET" action="{{ route('student.courses.enrolled') }}" class="mb-4">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <label for="semester" class="sr-only">Semester</label>
                                <select name="semester" id="semester" class="form-control">
                                    <option value="">All Semesters</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester }}" {{ $semester == $selectedSemester ? 'selected' : '' }}>
                                            {{ $semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <table id="datatable" class="table table-borderless table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Lecturer</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->lecturer ? $course->lecturer->name : 'No lecturer' }}</td>
                                    <td>{{ $course->semester }}</td>
                                    <td>
                                        <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
