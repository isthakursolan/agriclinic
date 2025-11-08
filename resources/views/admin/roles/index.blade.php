@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Roles Management</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;"><h3 class="card-title mb-0 text-white"><i class="bi bi-shield-check me-2"></i>Role Management</h3></div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="usersTable" class="datatable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Current Role</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name ?? $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->pluck('name')->join(', ') ?: 'No role' }}</td>
                                    <td class="text-center">
                                         <a href="{{ route('admin.roles.edit', $user->id) }}" class="btn btn-sm btn-dark" title="Update Roles">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- @if(!$user->hasRole(['admin','superadmin']))
                                            <a href="{{ route('admin.roles.edit', $user->id) }}" class="btn btn-sm btn-primary">Update</a>
                                        @else
                                            <span class="badge badge-secondary">Locked</span>
                                        @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    $('#usersTable').DataTable();
});
</script>

@endsection
