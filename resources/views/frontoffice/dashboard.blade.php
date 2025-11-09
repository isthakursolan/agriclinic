@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Front Office Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Info Boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box shadow-lg border-0 text-white" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); border-radius: 0.5rem; padding: 1.5rem;">
                            <span class="info-box-icon elevation-1" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 0.5rem;"><i class="fas fa-user-plus text-white" style="font-size: 1.5rem;"></i></span>
                            <div class="info-box-content" style="padding-left: 1rem;">
                                <span class="info-box-text text-white fw-semibold" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem;">New Farmers Today</span>
                                <span class="info-box-number text-white fw-bold" style="font-size: 2.5rem; line-height: 1.2; display: block;">{{ $newFarmersToday }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3 shadow-lg border-0 text-white" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border-radius: 0.5rem; padding: 1.5rem;">
                            <span class="info-box-icon elevation-1" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 0.5rem;"><i class="fas fa-vial text-white" style="font-size: 1.5rem;"></i></span>
                            <div class="info-box-content" style="padding-left: 1rem;">
                                <span class="info-box-text text-white fw-semibold" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem;">Samples Received Today</span>
                                <span class="info-box-number text-white fw-bold" style="font-size: 2.5rem; line-height: 1.2; display: block;">{{ $samplesReceivedToday }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3 shadow-lg border-0 text-white" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-radius: 0.5rem; padding: 1.5rem;">
                            <span class="info-box-icon elevation-1" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 0.5rem;"><i class="fas fa-money-bill-wave text-white" style="font-size: 1.5rem;"></i></span>
                            <div class="info-box-content" style="padding-left: 1rem;">
                                <span class="info-box-text text-white fw-semibold" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px; display: block; margin-bottom: 0.75rem;">Pending Payments</span>
                                <span class="info-box-number text-white fw-bold" style="font-size: 2.5rem; line-height: 1.2; display: block;">{{ $farmersWithPendingActions->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">
                        <!-- Recent Samples -->
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #777777;">
                                <h3 class="card-title mb-0 text-white">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Recently Received Samples
                                </h3>
                            </div>
                            <div class="card-body">
                                @if($recentSamples->count() > 0)
                                    <table class="table table-striped datatable table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sample ID</th>
                                                <th>Farmer</th>
                                                <th>Sample Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentSamples->sortBy('sample_id') as $sample)
                                                <tr>
                                                    <td><a href="#">{{ $sample->sample_id }}</a></td>
                                                    <td>{{ $sample->farmer->fullname ?? 'N/A' }}</td>
                                                    <td>{{ $sample->sampleType->name ?? 'N/A' }}</td>
                                                    <td>{{ $sample->created_at->format('d M, Y') }}</td>
                                                    <td>
                                                        @if($sample->sample_status == 'paid')
                                                            <span style="color: #777777;">Paid</span>
                                                        @elseif($sample->sample_status == 'collected')
                                                            <span style="color: #777777;">Collected</span>
                                                        @else
                                                            <span style="color: #777777;">Pending Payment</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-center text-muted">No samples received yet today.</p>
                                @endif
                            </div>
                        </div>
                    </section>

                    <!-- right col -->
                    <section class="col-lg-5 connectedSortable">
                        <!-- Farmers with Pending Actions -->
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #777777;">
                                <h3 class="card-title mb-0 text-white">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Farmers with Pending Payments
                                </h3>
                            </div>
                            <div class="card-body">
                                @if($farmersWithPendingActions->count() > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($farmersWithPendingActions as $farmer)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $farmer->fullname }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $farmer->contact }}</small>
                                                </div>
                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-center text-muted">No farmers with pending payments.</p>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
