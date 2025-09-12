@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-alt"></i> My Reports</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('agent.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card-body">
                        @if($reports->count() > 0)
                            <table id="reportsTable" class="datatable display table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Task</th>
                                        <th>Farmer</th>
                                        <th>Field</th>
                                        <th>Notes Preview</th>
                                        <th>Submitted</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                        <tr>
                                            <td>{{ $report->task->title }}</td>
                                            <td>
                                                @if($report->task->farmer)
                                                    {{ $report->task->farmer->fullname }}
                                                @else
                                                    <span class="text-muted">No farmer</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($report->task->field)
                                                    {{ $report->task->field->field_name }}
                                                @else
                                                    <span class="text-muted">No field</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($report->notes, 50) }}</td>
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
                                                    <a href="{{ route('agent.reports.show', $report->id) }}"
                                                       class="btn btn-sm btn-info" title="View Report">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    {{-- Allow editing if the report is pending or has been rejected --}}
                                                    @if($report->status == 'pending_review' || $report->status == 'rejected')
                                                        <a href="{{ route('agent.reports.edit', $report->id) }}" class="btn btn-sm btn-warning" title="Edit Report">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                </div>
                                                @if($report->status == 'rejected' && $report->rejection_reason)
                                                    <div class="text-danger mt-1" data-toggle="tooltip" title="Reason for rejection">
                                                        <small><i class="fas fa-exclamation-circle"></i> {{ $report->rejection_reason }}</small>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> You haven't submitted any reports yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#reportsTable').DataTable({
                "order": [[ 4, "desc" ]] // Sort by submitted date
            });
        });
    </script>
@endsection
