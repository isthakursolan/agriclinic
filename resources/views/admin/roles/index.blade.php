@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header"><h3 class="card-title">Role Management</h3></div>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name ?? $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->pluck('name')->join(', ') ?: 'No role' }}</td>
                                    <td>
                                         <a href="{{ route('admin.roles.edit', $user->id) }}" class="btn btn-sm btn-primary">Update</a>
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
    </section>
</div>
<script>
$(document).ready(function () {
    $('#usersTable').DataTable();
});
</script>

@endsection
