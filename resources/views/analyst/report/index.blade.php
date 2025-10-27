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
                                @forelse ($samples as $sample)
                                    @if ($sample->investigations->count() > 0)
                                        @foreach ($sample->investigations as $index => $investigation)
                                            <tr>
                                                {{-- Sample ID and Sample Type only on the first row --}}
                                                @if ($index == 0)
                                                    <td rowspan="{{ $sample->investigations->count() }}">
                                                        {{ $sample->sample_id }}</td>
                                                    <td rowspan="{{ $sample->investigations->count() }}">
                                                        {{ $sample->sampleType->e_type ?? 'N/A' }}
                                                    </td>
                                                @endif

                                                <td>{{ $investigation->parameters->parameter }}</td>
                                                <td>{{ $investigation->result ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('analyst.report.create', $sample->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        show Report
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5">No investigations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
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
