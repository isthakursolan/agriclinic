@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <!-- Search Form -->
                <div class="card card-info">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-search me-2"></i>Track Sample</h3>
                    </div>
                    <form action="{{ route('frontoffice.samples.track') }}" method="GET">
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="input-group">
                                <input type="text" name="sample_id" class="form-control" placeholder="Enter Sample ID (e.g., SMP-20231027-ABC123)" value="{{ request('sample_id') }}" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Track</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @if ($sample)
                <!-- Tracking Results -->
                <div class="card mt-4">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-clock-history me-2"></i>Tracking History for Sample #{{ $sample->sample_id }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Farmer:</strong> {{ $sample->farmer->profile->fullname ?? $sample->farmer->name }}<br>
                                <strong>Sample Type:</strong> {{ $sample->sampleType->e_type ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 text-md-right">
                                <strong>Status:</strong>
                                @if($sample->sample_status == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($sample->sample_status == 'pending')
                                    <span class="badge badge-warning">Pending Payment</span>
                                @else
                                    <span class="badge badge-info">{{ ucfirst($sample->sample_status) }}</span>
                                @endif
                                <br>
                                <strong>Registered On:</strong> {{ $sample->created_at->format('d M, Y h:i A') }}
                            </div>
                        </div>

                        <hr>

                        <h5 class="mt-4">Movement History</h5>
                        @if($trackingHistory && $trackingHistory->count() > 0)
                            <div class="timeline">
                                @foreach($trackingHistory as $movement)
                                    <div>
                                        <i class="fas fa-clock bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-calendar"></i> {{ $movement->timestamp->format('d M, Y h:i A') }}</span>
                                            <h3 class="timeline-header"><strong>{{ $movement->action }}</strong></h3>
                                            <div class="timeline-body">
                                                <strong>Location/Department:</strong> {{ $movement->target }}<br>
                                                @if($movement->user)
                                                    <strong>Handled By:</strong> {{ $movement->user->profile->fullname ?? $movement->user->name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div>
                                    <i class="fas fa-flag-checkered bg-gray"></i>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                No tracking history found for this sample yet.
                            </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </section>
    </div>
@endsection

