@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All batches</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table id="samplesTable" class="table datatable table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sample Id</th>
                                    <th>Sample Type</th>
                                    <th>Parameter</th>
                                    <th>Result</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($investigations as $i)
                                    <tr>
                                        <td>{{ $i->sample_id }}</td>
                                        <td>{{ $i->sample->sampleType->e_type ?? 'N/A' }}</td>
                                        <td>{{ $i->parameters->parameter }}</td>
                                        <td>{{ $i->result ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('lab.batches.parameter-edit', ['param' => $i->parameter, 'sample' => $i->sample_id]) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Update Result
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No Investigations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#samplesTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });
        });
    </script>
@endpush
