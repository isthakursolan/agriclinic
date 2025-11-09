@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-people me-2"></i> Assigned Farmers</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('agent.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card-body">
                        @if ($samples->count() > 0)
                            <table class="table datatable table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sample ID</th>
                                        <th>Farmer</th>
                                        {{-- <th>Agent Assigned</th> --}}
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($samples as $sample)
                                        <tr>
                                            <td>{{ $sample->sample_id }}</td>
                                            <td>{{ $sample->farmer->fullname }}</td>
                                            {{-- <td>{{ $sample->fieldAgent->name }}</td> --}}
                                            <td>
                                                @if ($sample->sample_status == 'collected')
                                                    <span style="color: #777777;">Collected</span>
                                                @else
                                                    <span style="color: #777777;">Pending Collection</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($sample->sample_status != 'collected')
                                                    <form action="{{ route('agent.samples.collect', $sample->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            Mark Collected
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">Collected on {{ $sample->collected_at }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> You don't have any Samples to Collect yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#farmersTable').DataTable();
        });
    </script>
@endsection
