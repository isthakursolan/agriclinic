@extends('layouts.app') <!-- your main layout -->

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i>Crop Types</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.crop.type.create') }}" class="btn btn-primary">Create New</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class=" datatable table table-bordered table-striped" id="cropCatTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        {{-- <th>Description</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($types as $t)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $t->e_type }}</td>
                                            {{-- <td>{{ $cat->description }}</td> --}}
                                            <td>
                                                <a href="{{ route('admin.crop.type.edit', $t->id) }}"
                                                    class="btn btn-sm btn-warning">Update</a>
                                                {{-- <form action="{{ route('admin.crop.type.destroy', $t->id) }}"
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
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#cropCatTable').DataTable(); // initialize datatable
        });
    </script>
@endsection
