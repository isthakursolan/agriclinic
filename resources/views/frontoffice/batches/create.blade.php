@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-plus-circle me-2"></i>Create Batch</h3>
                        {{-- <div class="card-tools">
                            <a href="{{ route('frontoffice.samples.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Register New Sample
                            </a>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('frontoffice.batches.create') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Sample ID</th>
                                            <th>Sample Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($samples->isEmpty())
                                            <tr>
                                                <td colspan="3" class="text-center">No accepted samples available for
                                                    batching.</td>
                                            </tr>
                                        @endif
                                        @foreach ($samples as $sample)
                                            {{-- @if ($sample->buffer !== null)
                                                @continue
                                            @endif --}}
                                            <tr>
                                                <td><input type="checkbox" name="sample_ids[]" value="{{ $sample->id }}">
                                                </td>
                                                <td>{{ $sample->sample_id }}</td>
                                                <td>{{ $sample->sampleType->e_type }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                             @if ($samples->isnotEmpty())
                            <button type="submit" class="btn btn-dark"><i class="bi bi-plus-circle me-2"></i>Create Batch Manually</button>
                            @endif
                        </form>
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
