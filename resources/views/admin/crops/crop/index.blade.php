@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Crops List</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Crops List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-flower1 me-2"></i>Crops</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.crops.create') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Create New
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
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
                                    <th class="text-center">Actions</th>
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
                                        <td class="text-center">
                                            <a href="{{ route('admin.crops.edit', $crop->id) }}"
                                                class="btn btn-sm btn-dark" title="Update Crop">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            {{-- <form action="{{ route('admin.crops.destroy', $crop->id) }}"
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
