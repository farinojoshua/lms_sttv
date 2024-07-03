@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Users</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @php
        $roles = [
            'admin' => 'Admin',
            'lecturer' => 'Lecturer',
            'student' => 'Student',
        ];
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="{{ route('admin.users.create') }}" class="mb-3 btn btn-primary">Add User</a>
                    <button type="button" class="mb-3 btn btn-secondary" data-toggle="modal"
                        data-target="#importModal">Import Users</button>

                    <!-- Import Modal -->
                    <div class="modal fade" id="importModal" tabindex="-1" role="dialog"
                        aria-labelledby="importModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Users from Excel</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.users.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file">Choose Excel file</label>
                                            <input type="file" class="form-control" id="file" name="file"
                                                required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Import Modal -->

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Profile Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        @if ($user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                                alt="Profile Photo" class="img-thumbnail" width="50">
                                        @else
                                            <img src="{{ asset('assets/images/users/default.png') }}" alt="Profile Photo"
                                                class="img-thumbnail" width="50">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $roles[$user->role] ?? ucfirst($user->role) }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <!-- Button trigger delete modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteUserModal{{ $user->id }}">Delete</button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteUserModalLabel{{ $user->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteUserModalLabel{{ $user->id }}">Delete User</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this user?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Delete Modal -->
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endpush
