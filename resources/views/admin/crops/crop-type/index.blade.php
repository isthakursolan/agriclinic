@extends('layouts.app') <!-- your main layout -->

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Crop Types</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Crop Types</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-tags me-2"></i>Crop Types</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.crop.types.create') }}" class="btn btn-dark mb-3"><i class="bi bi-plus-circle me-2"></i>Create New</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class=" datatable table table-bordered table-striped" id="cropCatTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        {{-- <th>Description</th> --}}
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($types as $t)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $t->e_type }}</td>
                                            {{-- <td>{{ $cat->description }}</td> --}}
                                            <td class="text-center">
                                                <a href="{{ route('admin.crop.types.edit', $t->id) }}"
                                                    class="btn btn-sm btn-dark" title="Update Type">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                {{-- <form action="{{ route('admin.crop.types.destroy', $t->id) }}"
                                                    method="get" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
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
            $('#cropCatTable').DataTable(); // initialize datatable
        });
    </script>
@endsection
