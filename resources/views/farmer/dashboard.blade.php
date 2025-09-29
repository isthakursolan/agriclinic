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
                    <p class="text-muted">Here's an overview of your farming activities.</p>

                    <div class="quick-actions mt-3">
                        <a href="{{ route('user.field') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Add Plot
                        </a>
                        <a href="{{ route('user.sample') }}" class="btn btn-success me-2">
                            <i class="fas fa-flask"></i> Submit Sample
                        </a>
                        <a href="{{ route('user.payments.show') }}" class="btn btn-warning">
                            <i class="fas fa-rupee-sign"></i> Make Payment
                        </a>
                    </div>
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
                                        <span class="badge rounded-pill
                                            @if($sample->sample_status === 'pending') bg-warning
                                            @elseif($sample->sample_status === 'accepted') bg-success
                                            @elseif($sample->sample_status === 'rejected') bg-danger
                                            @else bg-secondary @endif">
                                            {{ $sample->sample_status }}
                                        </span>
                                    </li>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No recent samples found</p>
                                        <a href="{{ route('farmer.samples.create') }}" class="btn btn-primary">
                                            Submit Your First Sample
                                        </a>
                                    </div>
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
            {{-- <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>Crop Health Status</h5>
                            <div class="progress mb-3">
                                <div class="progress-bar bg-success" style="width: 75%"></div>
                            </div>
                            <small class="text-muted">75% of your crops are healthy</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Need Help?</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5><i class="fas fa-question-circle text-primary me-2"></i> FAQs</h5>
                                    <p>Find answers to common questions</p>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View FAQs</a>
                                </div>
                                <div class="col-md-4">
                                    <h5><i class="fas fa-phone-alt text-success me-2"></i> Support</h5>
                                    <p>Contact our support team</p>
                                    <a href="#" class="btn btn-sm btn-outline-success">Contact Us</a>
                                </div>
                                <div class="col-md-4">
                                    <h5><i class="fas fa-book text-info me-2"></i> Guides</h5>
                                    <p>Learn how to use the platform</p>
                                    <a href="#" class="btn btn-sm btn-outline-info">View Guides</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
