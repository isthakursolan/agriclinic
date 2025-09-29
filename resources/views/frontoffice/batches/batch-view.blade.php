@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">Batch {{ $batch->batch_no }} Samples</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table datatable table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sample ID</th>
                                    <th>Sample Type</th>
                                    <th>Lab Ref No</th>
                                    <th>Parameters</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($samples as $sample)
                                    <tr>
                                        <td>{{ $sample->sample_id }}</td>
                                        <td>{{ $sample->sample->sampleType->e_type }}</td>
                                        <td> {{ $sample->lab_ref_no }}</td>
                                        {{-- <td><a href="{{ route('frontoffice.batches.parameters', ['batch' => $batch->id, 'sample' => $sample->id]) }}">View
                                                Parameters</a></td> --}}
                                        <td>{{ $sample->sample->parameter_names }}</td>
                                            {{-- @if (is_array($sample->sample->parameters))
                                                {{ implode(', ', $sample->sample->parameters) }}
                                            @else
                                                {{ $sample->sample->parameters }}
                                            @endif --}}
                                        </td>
                                        <td>{{ $sample->sample->sample_status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            <a href="{{ route('frontoffice.all-batches') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
