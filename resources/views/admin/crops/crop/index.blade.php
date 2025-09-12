@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="content-wrapper pt-4">
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-map-marked-alt"></i>Crops</h3>
                        </div>
                        <div class="row">
                            <div class="col text-end m-1">
                                <a href="{{ route('admin.crop.create') }}" class="btn btn-primary">Create New</a>
                            </div>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <table id="cropTable" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Type</th>
                                            <th>Variety</th>
                                            <th>Rootstock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($crops as $index => $crop)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $crop->crop }}</td>
                                                <td>{{ $crop->category->e_cat ?? '-' }}</td>
                                                <td>{{ $crop->cropType->e_type ?? '-' }}</td>
                                                <td>
                                                    @if ($crop->variety == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($crop->rootstock == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.crop.', $crop->id) }}"
                                                        class="btn btn-sm btn-warning">Update</a>
                                                    {{-- <form action="{{ route('admin.crop.destroy', $crop->id) }}"
                                                        method="get" class="d-inline"
                                                        onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#cropTable').DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    targets: 5
                }]
            });
        });
    </script>
@endsection
