@extends('layouts.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Admin Dashboard </h2>
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
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3>Welcome, {{ Auth::user()->name }} 👨‍🌾</h3>
                    <p class="text-muted">Here's an overview of activities.</p>


                    <div class="row">
                        <!-- User Statistics -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white d-flex justify-content-between">
                                    <span><i class="fas fa-users"></i> Users</span>
                                    <a href="{{ route('admin.roles') }}" class="text-white"><i
                                            class="fas fa-external-link-alt"></i></a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ $stats['users']['total'] }}</div>
                                            <div class="stat-label">Total</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ $stats['users']['farmers'] }}</div>
                                            <div class="stat-label">Farmers</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ $stats['users']['agents'] }}</div>
                                            <div class="stat-label">Agents</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Crops -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-success text-white d-flex justify-content-between">
                                    <span><i class="fas fa-seedling"></i> Active Crops</span>
                                    <a href="{{ route('admin.crops') }}" class="text-white"><i
                                            class="fas fa-external-link-alt"></i></a>
                                </div>
                                <div class="card-body text-center">
                                    <div class="stat-value">{{ $stats['active_crops'] }}</div>
                                    <div class="stat-label">Currently Active</div>
                                </div>
                            </div>
                        </div>

                        <!-- Fields -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-info text-white d-flex justify-content-between">
                                    <span><i class="fas fa-map-marked-alt"></i> Fields</span>
                                    <a href="#" class="text-white"><i class="fas fa-external-link-alt"></i></a>
                                </div>
                                <div class="card-body text-center">
                                    <div class="stat-value">{{ $stats['fields'] }}</div>
                                    <div class="stat-label">Registered Fields</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="row">
                        <!-- Samples -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-warning text-white d-flex justify-content-between">
                                    <span><i class="fas fa-flask"></i> Samples</span>
                                    <a href="{{ route('sample') }}" class="text-white"><i
                                            class="fas fa-external-link-alt"></i></a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ $stats['samples']['total'] }}</div>
                                            <div class="stat-label">Total</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ $stats['samples']['pending'] }}</div>
                                            <div class="stat-label">Pending</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ $stats['samples']['completed'] }}</div>
                                            <div class="stat-label">Completed</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payments -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-danger text-white d-flex justify-content-between">
                                    <span><i class="fas fa-money-bill-wave"></i> Payments</span>
                                    <a href="{{ route('payments.show') }}" class="text-white"><i
                                            class="fas fa-external-link-alt"></i></a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ number_format($stats['payments']['total'], 2) }}
                                            </div>
                                            <div class="stat-label">Total</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ number_format($stats['payments']['pending'], 2) }}
                                            </div>
                                            <div class="stat-label">Pending</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div class="stat-value">{{ number_format($stats['payments']['completed'], 2) }}
                                            </div>
                                            <div class="stat-label">Completed</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reports -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-secondary text-white d-flex justify-content-between">
                                    <span><i class="fas fa-file-alt"></i> Reports</span>
                                    {{-- <a href="{{ route('field-agents.reports') }}" class="text-white"><i class="fas fa-external-link-alt"></i></a> --}}
                                </div>
                                <div class="card-body text-center">
                                    <div class="stat-value">{{ $stats['reports'] }}</div>
                                    <div class="stat-label">Field Agent Reports</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-bolt"></i> Quick Actions
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('admin.crop') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-seedling"></i> Manage Crops
                                        </a>
                                        <a href="{{ route('sample') }}" class="btn btn-outline-warning">
                                            <i class="fas fa-flask"></i> View Samples
                                        </a>
                                        <a href="{{ route('admin.roles') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-users-cog"></i> Manage Users
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
