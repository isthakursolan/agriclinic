@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Field Agent Reports</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Field Agent Reports</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-file-text me-2"></i> Field Agent Reports</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.field-agents') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Back to Agents
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="reportsTable" class="datatable display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>#</th>
                                <th>Field Agent</th>
                                <th>Task</th>
                                <th>Farmer</th>
                                <th>Field</th>
                                <th>Submitted At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>#{{ $report->id }}</td>
                                    <td>
                                        {{ $report->fieldAgent->name }}
                                        @if($report->fieldAgent->profile)
                                            <br><small class="text-muted">{{ $report->fieldAgent->profile->fullname }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $report->task->title }}
                                        <br><small class="text-muted">{{ Str::limit($report->task->description, 30) }}</small>
                                    </td>
                                    <td>
                                        @if($report->task->farmer)
                                            {{ $report->task->farmer->fullname }}
                                            <br><small style="color: #777777;">{{ $report->task->farmer->contact }}</small>
                                        @else
                                            <span class="text-muted">No farmer assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($report->task->field)
                                            {{ $report->task->field->field_name }}
                                        @else
                                            <span class="text-muted">No field assigned</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->submitted_at->format('M d, Y H:i A') }}</td>
                                    <td>
                                        @if($report->status == 'approved')
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Approved</span>
                                        @elseif($report->status == 'rejected')
                                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Rejected</span>
                                        @else
                                            <span class="badge badge-warning text-dark"><i class="fas fa-hourglass-half"></i> Pending Review</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.field-agents.reports.show', $report->id) }}"
                                               class="btn btn-sm btn-info" title="View Report">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($report->status != 'approved')
                                                <form method="POST"
                                                      action="{{ route('admin.field-agents.reports.approve', $report->id) }}"
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                            title="Approve Report"
                                                            onclick="return confirm('Are you sure you want to approve this report?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
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
            $('#reportsTable').DataTable({
                "order": [[ 5, "desc" ]] // Sort by submitted date
            });
        });
    </script>
@endsection
