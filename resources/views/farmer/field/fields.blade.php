@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Fields</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('user.add.field') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Add Field
                            </a>
                        </div>
                    </div>
                     @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table id="myDataTable" class="display datatable table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>Field Name</th>
                                <th>Field Area</th>
                                <th>Crop</th>
                                <th>Source of irrigation</th>
                                <th>Soil Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fields as $field)
                                <tr>
                                    <td>{{ $field->field_name }}</td>
                                    <td>{{ $field->field_area }}</td>
                                    <td>{{ $field->lastCrop ? $field->lastCrop->name:' ' }}</td>
                                    <td>{{ $field->source_of_irrigation }}</td>
                                    <td>{{ $field->soil_type }}</td>
                                    <td>
                                        <a href="{{ route('user.edit.field', $field->id) }}"
                                            class="btn btn-sm btn-warning">Update</a>
                                        {{-- <form action="{{ route('user.field.destroy', $field->id) }}" method="get"
                                            class="d-inline">
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
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>
@endsection
