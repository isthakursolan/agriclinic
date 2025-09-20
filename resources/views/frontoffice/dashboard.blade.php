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
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">New Farmers Today</span>
                                <span class="info-box-number">{{ $newFarmersToday }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-vial"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Samples Received Today</span>
                                <span class="info-box-number">{{ $samplesReceivedToday }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pending Payments</span>
                                <span class="info-box-number">{{ $farmersWithPendingActions->count() }}</span>
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
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-history mr-1"></i>
                                    Recently Received Samples
                                </h3>
                            </div>
                            <div class="card-body">
                                @if($recentSamples->count() > 0)
                                    <table class="table table-striped">
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
                                                            <span class="text-success">Paid</span>
                                                        @elseif($sample->sample_status == 'collected')
                                                            <span class="text-primary">Collected</span>
                                                        @else
                                                            <span class="text-warning">Pending Payment</span>
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
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-exclamation-triangle mr-1 text-warning"></i>
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
