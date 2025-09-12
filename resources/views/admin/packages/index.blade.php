@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Packages</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                                Add Packages
                            </a>
                        </div>
                    </div>

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
                                <th>Actions</th>
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
                                    <td>
                                        <a href="{{ route('admin.packages.edit', $package->id) }}"
                                            class="btn btn-primary btn-sm">Update</a>
                                        {{-- <form action="{{ route('admin.packages.destroy', $package->id) }}" method="get"
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
        </section>
    </div>
@endsection
