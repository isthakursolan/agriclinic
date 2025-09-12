@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Sample Types</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.sampleType.create') }}" class="btn btn-primary">
                                Add Sample Type
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
                                <th>Type</th>
                                {{-- <th>H Type</th> --}}
                                <th>Sample Size</th>
                                <th>Buffer Size</th>
                                <th>Batch Prefix</th>
                                <th>Actions</th>
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
                                    <td>
                                        <a href="{{ route('admin.sampleType.edit', $type->id) }}"
                                            class="btn btn-primary btn-sm">Update</a>
                                        {{-- <form action="{{ route('admin.sampleType.destroy', $type->id) }}" method="get"
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
        </section>
    </div>
@endsection
