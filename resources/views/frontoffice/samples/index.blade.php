@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Samples</h3>
                        <div class="card-tools">
                            <a href="{{ route('frontoffice.samples.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Register New Sample
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table id="samplesTable" class="table table-bordered table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Sample ID</th>
                                    <th>Farmer</th>
                                    <th>Sample Type</th>
                                    <th>Date Registered</th>
                                    <th>Amount (₹)</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($samples as $sample)
                                    <tr>
                                        <td>{{ $sample->sample_id }}</td>
                                        <td>{{ $sample->farmer->fullname ?? $sample->farmer->name }}</td>
                                        <td>{{ $sample->sampleType->e_type ?? 'N/A' }}</td>
                                        <td>{{ $sample->created_at->format('d M, Y') }}</td>
                                        <td>{{ number_format($sample->amount, 2) }}</td>
                                         <td>
                                            @if($sample->sample_status == 'paid')
                                                <span class="text-success font-weight-bold">Paid</span>
                                            @elseif($sample->sample_status == 'pending')
                                                <span class="text-warning font-weight-bold">Pending Payment</span>
                                            @else
                                                <span class="text-info font-weight-bold">{{ ucfirst($sample->sample_status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('frontoffice.samples.track', ['sample_id' => $sample->sample_id]) }}" class="btn btn-sm btn-info"><i class="fas fa-route"></i> Track</a>
                                            {{-- Add other actions like 'View Details' or 'Generate Invoice' later --}}
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

