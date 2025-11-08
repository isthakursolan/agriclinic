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
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #15803d 0%, #0f5d2a 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">My Plots</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $fields_count }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Active Crops</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $crops_count }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Total Samples</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $samples_count }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Pending Payments</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $pending_payments }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h4 class="card-title mb-0 text-white"><i class="bi bi-vial me-2"></i>Recent Samples</h4>
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
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h4 class="card-title mb-0 text-white"><i class="bi bi-credit-card me-2"></i>Recent Payments</h4>
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
