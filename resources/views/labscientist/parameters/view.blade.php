@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Parameter Report for {{ $parameter->parameter }} in Batch
                            {{ $batch->batch_no }} with Sample Type {{ $batch->sampleType->e_type }} </h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table id="parametersTable" class="table datatable table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Sample Id</th>
                                    <th>Lab Ref No </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($samples as $sample)
                                    <tr>
                                        <td>{{ $parameter->parameter }}</td>
                                        <td>{{ $sample->sample_id }}</td>
                                        <td>{{ $sample->lab_ref_no }}</td>
                                        <td>
                                            <a href="{{ route('lab.batches.parameter-edit', ['param' => $parameter['id'], 'sample' => $sample->sample_id]) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Update Result
                                            </a>
                                            @if($sample->investigations[0]->result)
                                            {{-- <a href="{{ route('lab.batches.result-view', ['param' => $parameter['id'], 'sample' => $sample->sample_id]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="fas fa-eye"></i> View Result
                                            </a> --}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                         <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#parametersTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        title: 'Batch Parameters Report',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        title: 'Batch Parameters Report',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
        });
    </script>
@endpush
