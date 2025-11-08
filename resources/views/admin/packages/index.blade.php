@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Test Packages</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Test Configuration</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Test Packages</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-box-seam me-2"></i> Packages</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.test-packages.create') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Add Packages
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
                                <th>Package Name</th>
                                <th>Sample Type</th>
                                <th>Price</th>
                                <th>Reporting Time</th>
                                <th>Parameters</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->package_name }}</td>
                                    <td>{{ $package->sampleType->e_type ?? '-' }}</td>
                                    <td>{{ $package->price }}</td>
                                    <td>{{ $package->reporting_time }}</td>
                                    <td>
                                        @if ($package->parameters)
                                            @php $params = json_decode($package->parameters, true); @endphp
                                            @foreach ($params as $p)
                                                {{ \App\Models\individualParameterModel::find($p)->parameter ?? '' }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.test-packages.edit', $package->id) }}"
                                            class="btn btn-dark btn-sm" title="Update Package">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- <form action="{{ route('admin.test-packages.destroy', $package->id) }}" method="get"
                                            class="d-inline" onsubmit="return confirm('Delete this package?')">
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
