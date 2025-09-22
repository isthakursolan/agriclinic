@extends('layouts.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Farmer Dashboard</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3>Welcome, {{ Auth::user()->name }} 👨‍🌾</h3>
                    <p class="text-muted">Here’s an overview of your farming activities.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">My Plots</h5>
                            <p class="card-text fs-4">{{ $fields_count }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Active Crops</h5>
                            <p class="card-text fs-4">{{ $crops_count }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Samples</h5>
                            <p class="card-text fs-4">{{ $samples_count }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Pending Payments</h5>
                            <p class="card-text fs-4">{{ $pending_payments }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4 class="card-title">Recent Samples</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse ($recent_samples as $sample)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Sample ID: {{ $sample->sample_id }}</span>
                                        <span class="badge bg-primary rounded-pill">{{ $sample->sample_status }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item">No recent samples found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4 class="card-title">Recent Payments</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse ($recent_payments as $payment)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Transaction ID: {{ $payment->transaction_id ?? 'N/A' }}</span>
                                        <span class="badge bg-success rounded-pill">₹{{ $payment->amount }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item">No recent payments found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
