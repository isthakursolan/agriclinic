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
                <div class="row">
                    <!-- Batch Statistics -->
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Total Batches</h5>
                                        <p class="card-text display-4">{{ $batchCount }}</p>
                                    </div>
                                    <i class="fas fa-flask fa-3x"></i>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-light" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Investigations -->
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Pending Investigations</h5>
                                        <p class="card-text display-4">{{ $pendingInvestigations }}</p>
                                    </div>
                                    <i class="fas fa-hourglass-half fa-3x"></i>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-light" style="width: {{ $investigationProgress }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reports -->
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Completed Reports</h5>
                                        <p class="card-text display-4">{{ $completedReports }}</p>
                                    </div>
                                    <i class="fas fa-file-alt fa-3x"></i>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-light" style="width: {{ $reportProgress }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Urgent Samples -->
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title">Urgent Samples</h5>
                                        <p class="card-text display-4">{{ $urgentSamples }}</p>
                                    </div>
                                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-light" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity and Charts -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5>Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    {{-- @foreach ($recentActivities as $activity)
                            <li class="list-group-item">
                                <i class="fas fa-circle text-{{ $activity->type }}"></i>
                                {{ $activity->description }}
                                <span class="float-right text-muted small">{{ $activity->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach --}}
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5>Weekly Progress</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="weeklyProgressChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@section('scripts')
    <script>
        // Weekly Progress Chart
        var ctx = document.getElementById('weeklyProgressChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($weeklyLabels) !!},
                datasets: [{
                    label: 'Completed Reports',
                    data: {!! json_encode($weeklyData) !!},
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
@endsection
