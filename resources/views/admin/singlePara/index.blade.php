@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Test Parameters</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Test Configuration</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Test Parameters</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-list-check me-2"></i> Individual Parameters</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.test-parameters.create') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Add Parameter
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
                                <th>Parameter</th>
                                <th>Symbol</th>
                                <th>Reporting Time</th>
                                <th>Price</th>
                                <th>Sample Type</th>
                                <th>Reading Type</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parameters as $param)
                                <tr>
                                    <td>{{ $param->id }}</td>
                                    <td>{{ $param->parameter }}</td>
                                    <td>{{ $param->symbol }}</td>
                                    <td>{{ $param->reporting_time }}</td>
                                    <td>{{ $param->price }}</td>
                                    <td>{{ $param->sampleType->e_type ?? '-' }}</td>
                                    <td>{{ $param->reading_type }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.test-parameters.edit', $param->id) }}"
                                            class="btn btn-dark btn-sm" title="Update Parameter">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- <form action="{{ route('admin.test-parameters.destroy', $param->id) }}"
                                            method="get" class="d-inline"
                                            onsubmit="return confirm('Delete this parameter?')">
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
