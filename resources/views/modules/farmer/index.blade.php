@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Manage Farmers</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Farmers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Manage Farmers</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('farmer.create') }}" class="btn btn-dark mb-3"><i class="bi bi-plus-circle me-2"></i>Add Farmer</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <table class="datatable table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($farmers as $farmer)
                                    <tr>
                                        <td>{{ $farmer->id }}</td>
                                        <td>{{ $farmer->name }}</td>
                                        <td>{{ $farmer->username }}</td>
                                        <td>{{ $farmer->email }}</td>
                                        <td>{{ $farmer->contact }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('farmer.edit', $farmer->id) }}"
                                                class="btn btn-dark btn-sm" title="Update">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            {{-- <form action="{{ route('farmer.destroy', $farmer->id) }}" method="get"
                                                style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Delete this farmer?')">Delete</button>
                                            </form> --}}
                                        </td>
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
