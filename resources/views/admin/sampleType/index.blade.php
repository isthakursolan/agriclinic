@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Sample Types</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Test Configuration</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sample Types</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-clipboard-data me-2"></i> Sample Types</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.sample-types.create') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Add Sample Type
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="datatable table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                {{-- <th>H Type</th> --}}
                                <th>Sample Size</th>
                                <th>Buffer Size</th>
                                <th>Batch Prefix</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr>
                                    <td>{{ $type->id }}</td>
                                    <td>{{ $type->e_type }}</td>
                                    {{-- <td>{{ $type->h_type }}</td> --}}
                                    <td>{{ $type->sample_size }}</td>
                                    <td>{{ $type->buffer_size }}</td>
                                    <td>{{ $type->batch_prefix }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.sample-types.edit', $type->id) }}"
                                            class="btn btn-dark btn-sm" title="Update Sample Type">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- <form action="{{ route('admin.sample-types.destroy', $type->id) }}" method="get"
                                            class="d-inline" onsubmit="return confirm('Delete this sample type?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
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
