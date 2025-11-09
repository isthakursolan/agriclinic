@extends('layouts.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Analyst Dashboard</h2>
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
                    <h3>Welcome, {{ Auth::user()->name }}</h3>
                    <p class="text-muted">Here's an overview of your analytics activities.</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #15803d 0%, #0f5d2a 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;"><i class="bi bi-graph-up me-2"></i>Total Reports</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;"><i class="bi bi-clipboard-data me-2"></i>Analyzed Cases</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;"><i class="bi bi-check-circle me-2"></i>Completed</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;"><i class="bi bi-hourglass-split me-2"></i>Pending</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

