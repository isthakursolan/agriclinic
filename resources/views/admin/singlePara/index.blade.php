@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Individual Parameters</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.singlePara.create') }}" class="btn btn-primary">
                                Add Parameter
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
                                <th>Parameter</th>
                                <th>Symbol</th>
                                <th>Reporting Time</th>
                                <th>Price</th>
                                <th>Sample Type</th>
                                <th>Reading Type</th>
                                <th>Actions</th>
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
                                    <td>
                                        <a href="{{ route('admin.singlePara.edit', $param->id) }}"
                                            class="btn btn-primary btn-sm">Update</a>
                                        {{-- <form action="{{ route('admin.singlePara.destroy', $param->id) }}"
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
        </section>
    </div>
@endsection
