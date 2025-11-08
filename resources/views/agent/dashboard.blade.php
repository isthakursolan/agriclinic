@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Field Agent Dashboard</h2>
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
                    <h3>Welcome, {{ Auth::user()->name }} 🌾</h3>
                    <p class="text-muted">Here's an overview of your field activities.</p>

                    <!-- Statistics Cards -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #15803d 0%, #0f5d2a 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Assigned Farmers</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $assignedFarmersCount }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Active Fields</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $fieldsCount }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Pending Tasks</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $pendingTasks }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); transition: transform 0.3s ease;">
                                <div class="card-body px-4 py-4">
                                    <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Completed Tasks</h5>
                                    <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $completedTasks }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Overdue Tasks Alert -->
                    @if($overdueTasks > 0)
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Attention!</strong> You have {{ $overdueTasks }} overdue task(s).
                            <a href="{{ route('agent.tasks') }}" class="alert-link">View Tasks</a>
                        </div>
                    @endif

                    <!-- Recent Tasks -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #777777;">
                                    <h5><i class="bi bi-list-task me-2"></i> Upcoming Tasks</h5>
                                </div>
                                <div class="card-body">
                                    @if($recentTasks->count() > 0)
                                        <div class="list-group list-group-flush">
                                            @foreach($recentTasks as $task)
                                                <div class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{ $task->title }}</h6>
                                                        <small class="text-muted">
                                                            @if($task->due_date)
                                                                {{ $task->due_date->diffForHumans() }}
                                                                @if($task->due_date < now())
                                                                    <span class="badge badge-danger">Overdue</span>
                                                                @endif
                                                            @endif
                                                        </small>
                                                    </div>
                                                    <p class="mb-1">{{ Str::limit($task->description, 50) }}</p>
                                                    <small>
                                                        @if($task->farmer)
                                                            Farmer: {{ $task->farmer->fullname }}
                                                        @endif
                                                        @if($task->field)
                                                            | Field: {{ $task->field->field_name }}
                                                        @endif
                                                    </small>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{ route('agent.tasks') }}" class="btn btn-primary">View All Tasks</a>
                                        </div>
                                    @else
                                        <p class="text-muted">No pending tasks.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Recent Reports -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #777777;">
                                    <h5><i class="bi bi-file-text me-2"></i> Recent Reports</h5>
                                </div>
                                <div class="card-body">
                                    @if($recentReports->count() > 0)
                                        <div class="list-group list-group-flush">
                                            @foreach($recentReports as $report)
                                                <div class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{ $report->task->title }}</h6>
                                                        <small style="color: #777777;">{{ $report->submitted_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mb-1">{{ Str::limit($report->notes, 50) }}</p>
                                                    <small>
                                                        @if($report->task->farmer)
                                                            Farmer: {{ $report->task->farmer->fullname }}
                                                        @endif
                                                    </small>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{ route('agent.reports') }}" class="btn btn-success">View All Reports</a>
                                        </div>
                                    @else
                                        <p class="text-muted">No reports submitted yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #777777;">
                                    <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
                                </div>
                                <div class="card-body text-center">
                                    <a href="{{ route('agent.farmers') }}" class="btn btn-primary btn-lg m-2">
                                        <i class="bi bi-people me-2"></i><br>My Farmers
                                    </a>
                                    <a href="{{ route('agent.fields') }}" class="btn btn-info btn-lg m-2">
                                        <i class="bi bi-flower1 me-2"></i><br>Fields
                                    </a>
                                    <a href="{{ route('agent.tasks') }}" class="btn btn-warning btn-lg m-2">
                                        <i class="bi bi-list-task me-2"></i><br>Tasks
                                    </a>
                                    <a href="{{ route('agent.reports') }}" class="btn btn-success btn-lg m-2">
                                        <i class="bi bi-file-text me-2"></i><br>Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
