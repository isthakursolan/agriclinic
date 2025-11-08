@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Field Agents Management</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Field Agents</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-people me-2"></i> Field Agents Management</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.field-agents.assign-form') }}" class="btn btn-primary mb-3">
                                <i class="bi bi-person-plus me-2"></i> Assign Farmer
                            </a>
                            <a href="{{ route('admin.field-agents.create-task') }}" class="btn btn-info mb-3">
                                <i class="bi bi-list-task me-2"></i> Create Task
                            </a>
                            <a href="{{ route('admin.field-agents.assigned-farmers') }}" class="btn btn-warning mb-3">
                                <i class="bi bi-list-ul me-2"></i> View Assignments
                            </a>
                            <a href="{{ route('admin.field-agents.reports') }}" class="btn btn-success mb-3">
                                <i class="bi bi-file-text me-2"></i> View Reports
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="myDataTable" class="datatable display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>#</th>
                                <th>Agent Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Assignments (Farmers/Fields)</th>
                                <th>Total Tasks</th>
                                <th>Pending Tasks</th>
                                <th>In Progress</th>
                                <th>Completed Tasks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agents as $agent)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $agent->name }}
                                        @if($agent->profile)
                                            <br><small class="text-muted">{{ $agent->profile->fullname }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $agent->contact }}
                                        @if($agent->profile && $agent->profile->whatsapp)
                                            <br><small style="color: #777777;">WhatsApp: {{ $agent->profile->whatsapp }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $agent->email }}</td>
                                    <td>
                                        <span class="badge badge-info text-dark">{{ $agent->assignedFarmersCount }} Farmers</span> /
                                        <span class="badge badge-secondary">{{ $agent->fieldsCount }} Fields</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $agent->totalTasks }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning text-dark">{{ $agent->pendingTasks }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info text-dark">{{ $agent->inProgressTasks }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $agent->completedTasks }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.field-agents.tasks', $agent->id) }}"
                                               class="btn btn-sm btn-info" title="View Tasks">
                                                <i class="bi bi-list-task me-2"></i> View Tasks
                                            </a>
                                            {{-- <a href="{{ route('admin.field-agents.reports.by-agent', $agent->id) }}"
                                               class="btn btn-sm btn-success" title="View Reports">
                                                <i class="bi bi-file-text me-2"></i>
                                            </a> --}}
                                            <a href="{{ route('admin.field-agents.create-task') }}?agent={{ $agent->id }}"
                                               class="btn btn-sm btn-primary" title="Assign Task">
                                                <i class="bi bi-plus-circle me-2"></i> Assign Tasks
                                            </a>
                                            <a href="{{ route('admin.field-agents.assign-form') }}?agent={{ $agent->id }}"
                                               class="btn btn-sm btn-warning" title="Assign Farmer">
                                                <i class="bi bi-person-plus me-2"></i>Assign Farmer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>
@endsection
