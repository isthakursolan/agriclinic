@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Manage Farmers</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('farmer.create') }}" class="btn btn-primary mb-3">Add Farmer</a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="datatable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($farmers as $farmer)
                                <tr>
                                    <td>{{ $farmer->name }}</td>
                                    <td>{{ $farmer->username }}</td>
                                    <td>{{ $farmer->email }}</td>
                                    <td>{{ $farmer->contact }}</td>
                                    <td>
                                        <a href="{{ route('farmer.edit', $farmer->id) }}"
                                            class="btn btn-warning btn-sm">Update</a>
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
        </section>
    </div>
@endsection
