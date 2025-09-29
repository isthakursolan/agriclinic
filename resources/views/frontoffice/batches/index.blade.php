@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All batches</h3>
                        <div class="card-tools">
                            <a href="{{ route('frontoffice.batches') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New Batch
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table id="samplesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Batch No</th>
                                    <th>Sample Type</th>
                                    <th>Number of sample</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($batches as $batch)
                                    <tr>
                                        <td>{{ $batch->batch_no }}</td>
                                        <td>{{ $batch->sampleType->e_type ?? 'N/A' }}</td>
                                        <td>{{ $batch->sample_no }}</td>
                                        <td>{{ $batch->date }}</td>
                                        <td>{{ ucfirst($batch->batch_status) }}</td>
                                        <td>
                                            <a href="{{ route('frontoffice.batches.view', $batch->id) }}"
                                                class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>View
                                            </a>
                                            <a href="{{ route('frontoffice.batches.parameters', $batch->id) }}"
                                                class="btn btn-sm btn-primary" title="Parameters">
                                                <i class="fas fa-list"></i>Parameters
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <h4 class="text-muted">No batches created yet</h4>
                                            <a href="{{ route('frontoffice.batches') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-plus"></i> Create First Batch
                                            </a>
                                        </td>
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
