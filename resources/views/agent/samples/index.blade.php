@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users"></i> Assigned Farmers</h3>
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
                            <table class="table table-bordered">
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
                                                    <span class=" text-success">Collected</span>
                                                @else
                                                    <span class=" text-warning">Pending Collection</span>
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
                                <i class="fas fa-info-circle"></i> You don't have any Samples to Collect yet.
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
