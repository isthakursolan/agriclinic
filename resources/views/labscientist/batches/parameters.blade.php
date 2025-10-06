@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">Batch {{ $batch->batch_no }} Samples Parameters</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="container">
                            <h4>No of Samples :- {{ $batch->sample_no }} in Batch {{ $batch->batch_no }} of Sample Type :-
                                {{ $batch->sampleType->e_type }}</h4>
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Parameter</th>
                                        <th>No. of Samples</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($parametersWithCount as $parameter)
                                        <tr>
                                            <td>{{ $parameter['parameter'] }}</td>
                                            <td>{{ $parameter['sample_count'] }}</td>
                                            <td>
                                                <a href="{{ route('lab.batches.parameter', ['param' => $parameter['id'], 'batch' => $batch->batch_no]) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <a href="{{ route('lab.batches.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
