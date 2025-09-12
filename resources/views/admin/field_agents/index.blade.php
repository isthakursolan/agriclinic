@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users"></i> Field Agents Management</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.field-agents.assign-form') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Assign Farmer
                            </a>
                            <a href="{{ route('admin.field-agents.create-task') }}" class="btn btn-info">
                                <i class="fas fa-tasks"></i> Create Task
                            </a>
                            <a href="{{ route('admin.field-agents.assigned-farmers') }}" class="btn btn-warning">
                                <i class="fas fa-list"></i> View Assignments
                            </a>
                            <a href="{{ route('admin.field-agents.reports') }}" class="btn btn-success">
                                <i class="fas fa-file-alt"></i> View Reports
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="myDataTable" class="datatable display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
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
                                    <td>
                                        {{ $agent->name }}
                                        @if($agent->profile)
                                            <br><small class="text-muted">{{ $agent->profile->fullname }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $agent->contact }}
                                        @if($agent->profile && $agent->profile->whatsapp)
                                            <br><small class="text-success">WhatsApp: {{ $agent->profile->whatsapp }}</small>
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
                                                <i class="fas fa-tasks"></i> View Tasks
                                            </a>
                                            {{-- <a href="{{ route('admin.field-agents.reports.by-agent', $agent->id) }}"
                                               class="btn btn-sm btn-success" title="View Reports">
                                                <i class="fas fa-file-alt"></i>
                                            </a> --}}
                                            <a href="{{ route('admin.field-agents.create-task') }}?agent={{ $agent->id }}"
                                               class="btn btn-sm btn-primary" title="Assign Task">
                                                <i class="fas fa-plus"></i> Assign Tasks
                                            </a>
                                            <a href="{{ route('admin.field-agents.assign-form') }}?agent={{ $agent->id }}"
                                               class="btn btn-sm btn-warning" title="Assign Farmer">
                                                <i class="fas fa-user-plus"></i>Assign Farmer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>
@endsection
