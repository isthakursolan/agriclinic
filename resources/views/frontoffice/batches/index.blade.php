@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-stack me-2"></i>All batches</h3>
                        <div class="card-tools">
                            <a href="{{ route('frontoffice.batches') }}" class="btn btn-dark">
                                <i class="bi bi-plus-circle me-2"></i> Create New Batch
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
                                @foreach ($batches as $batch)
                                    <tr>
                                        <td>{{ $batch->batch_no }}</td>
                                        <td>{{ $batch->sampleType->e_type ?? 'N/A' }}</td>
                                        <td>{{ $batch->sample_no }}</td>
                                        <td>{{ $batch->date }}</td>
                                        <td>{{ ucfirst($batch->batch_status) }}</td>
                                        <td>
                                            Action
                                            {{--Add other actions like 'View Details' or 'Generate Invoice' later --}}
                                        </td>
                                    </tr>
                                @endforeach
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

