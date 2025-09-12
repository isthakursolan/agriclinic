@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Farmers</h3>
                        <div class="card-tools">
                            <a href="{{ route('frontoffice.farmers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Farmer
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table id="farmersTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($farmers as $farmer)
                                    <tr>
                                        <td>{{ $farmer->id }}</td>
                                        <td>{{ $farmer->profile->fullname ?? $farmer->name }}</td>
                                        <td>{{ $farmer->username }}</td>
                                        <td>{{ $farmer->email }}</td>
                                        <td>{{ $farmer->contact }}</td>
                                        <td>
                                            <a href="{{ route('frontoffice.farmers.edit', $farmer->id) }}"
                                                class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                                            {{-- <a href="{{ route('frontoffice.farmers.destroy', $farmer->id) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this farmer?');"><i
                                                    class="fas fa-trash"></i> Delete</a> --}}
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
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#farmersTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });
        });
    </script>
@endpush
