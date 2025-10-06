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
                                            <a href="{{ route('lab.batches.show', $batch->id) }}"
                                                class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>View
                                            </a>
                                            <a href="{{ route('lab.batches.parameters', $batch->id) }}"
                                                class="btn btn-sm btn-primary" title="Parameters">
                                                <i class="fas fa-list"></i>Parameters
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No batches found.</td>
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
