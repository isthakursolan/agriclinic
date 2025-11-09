@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Samples</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('user.sample.create') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Book Test
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    {{-- <div class="card-body">
                        <div class="progress-tracker mb-4">
                            <h5>Submission Progress</h5>
                            <div class="steps">
                                <div class="step @if ($sample->sample_status == 'pending') active @endif">
                                    <span class="step-number">1</span>
                                    <span class="step-text">Submitted</span>
                                </div>
                                <div class="step @if ($sample->sample_status == 'accepted') active @endif">
                                    <span class="step-number">2</span>
                                    <span class="step-text">Accepted</span>
                                </div>
                                <div class="step @if ($sample->sample_status == 'collected') active @endif">
                                    <span class="step-number">3</span>
                                    <span class="step-text">Collected</span>
                                </div>
                                <div class="step @if ($sample->sample_status == 'completed') active @endif">
                                    <span class="step-number">4</span>
                                    <span class="step-text">Completed</span>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <table id="myDataTable" class="datatable display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>Sample Code</th>
                                <th>Crop</th>
                                <th>Field</th>
                                <th>Sample Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Concern</th>
                                <th>Action</th>
                                {{-- <th>Investigations</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($samples as $sample)
                                <tr>
                                    <td>{{ $sample->sample_id }}</td>
                                    <td>
                                        @foreach ($crop as $c)
                                            @if ($sample->crop_id === $c->id)
                                                {{ $c->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($field as $f)
                                            @if ($sample->field_id === $f->id)
                                                {{ $f->field_name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($type as $s)
                                            @if ($sample->sample_type == $s->id)
                                                {{ $s->e_type }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $sample->amount }}</td>
                                    <td><span
                                            class="badge
                                            @if ($sample->sample_status == 'pending') text-warning
                                            @elseif($sample->sample_status == 'accepted') text-success
                                            @elseif($sample->sample_status == 'paid') text-success
                                            @elseif($sample->sample_status == 'collected') text-info
                                            @else badge-secondary @endif
                                        ">{{ ucfirst($sample->sample_status) }}</span>
                                    </td>
                                    <td>{{ $sample->concern }}</td>
                                    <td class="text-center">
                                        @if ($sample->sample_status == 'pending')
                                            <a href="{{ route('user.payments.show', $sample->id) }}"
                                                class="btn btn-success btn-sm"><i class="fas fa-credit-card"></i> Pay</a>
                                            {{-- <a href="{{ route('user.samples.edit', $sample->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-square me-2"></i> Edit</a> --}}
                                        @else
                                            <a href="{{ route('user.samples.details', $sample->id) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                        @endif
                                        @if ($sample->sample_status == 'collected')
                                            <div class="timeline-indicator">
                                                <small>Estimated completion:</small>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: {{ $sample->progress }}%">
                                                    </div>
                                                </div>
                                                <small>{{ $sample->estimated_completion }}</small>
                                            </div>
                                        @endif
                                    </td>
                                @empty
                                    <td colspan="8" class="text-center">No samples found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Historical Comparison</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="sampleTimelineChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="cropHealthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>
@endsection
