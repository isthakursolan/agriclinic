@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-alt"></i> Report Details - #{{ $report->id }}</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.field-agents.reports') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Reports
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card-body">
                        <div class="row">
                            <!-- Report Information -->
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle"></i> Report Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Report ID:</strong></td>
                                        <td>#{{ $report->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Submitted At:</strong></td>
                                        <td>{{ $report->submitted_at->format('M d, Y H:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if($report->status == 'approved')
                                                <span class="badge badge-success"><i class="fas fa-check-circle"></i> Approved</span>
                                            @elseif($report->status == 'rejected')
                                                <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Rejected</span>
                                            @else
                                                <span class="badge badge-warning text-dark"><i class="fas fa-hourglass-half"></i> Pending Review</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Field Agent Information -->
                            <div class="col-md-6">
                                <h5><i class="fas fa-user"></i> Field Agent Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Agent Name:</strong></td>
                                        <td>{{ $report->fieldAgent->name }}</td>
                                    </tr>
                                    @if($report->fieldAgent->profile)
                                    <tr>
                                        <td><strong>Full Name:</strong></td>
                                        <td>{{ $report->fieldAgent->profile->fullname }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><strong>Contact:</strong></td>
                                        <td>{{ $report->fieldAgent->contact }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $report->fieldAgent->email }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <!-- Task Information -->
                            <div class="col-md-6">
                                <h5><i class="fas fa-tasks"></i> Task Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Task Title:</strong></td>
                                        <td>{{ $report->task->title }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Description:</strong></td>
                                        <td>{{ $report->task->description }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Due Date:</strong></td>
                                        <td>
                                            {{ $report->task->due_date ? $report->task->due_date->format('M d, Y') : 'No deadline' }}
                                            @if($report->task->due_date && $report->task->due_date < now() && $report->task->status != 'completed')
                                                <span class="badge badge-danger">Overdue</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Farmer & Field Information -->
                            <div class="col-md-6">
                                <h5><i class="fas fa-seedling"></i> Farmer & Field Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Farmer:</strong></td>
                                        <td>
                                            @if($report->task->farmer)
                                                {{ $report->task->farmer->fullname }}
                                                <br><small class="text-success">{{ $report->task->farmer->contact }}</small>
                                            @else
                                                <span class="text-muted">No farmer assigned</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Field:</strong></td>
                                        <td>
                                            @if($report->task->field)
                                                {{ $report->task->field->field_name }}
                                                @if($report->task->field->location)
                                                    <br><small class="text-muted">{{ $report->task->field->location }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">No field assigned</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Report Notes -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5><i class="fas fa-sticky-note"></i> Report Notes</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @if($report->notes)
                                            {{ $report->notes }}
                                        @else
                                            <span class="text-muted">No notes provided</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attachments -->
                        @if($report->attachments)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5><i class="fas fa-paperclip"></i> Attachments</h5>
                                <div class="row">
                                    @foreach(json_decode($report->attachments, true) as $attachment)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ asset('storage/' . $attachment) }}"
                                                             class="img-fluid"
                                                             style="max-height: 200px;"
                                                             alt="Report Image">
                                                    @else
                                                        <i class="fas fa-file fa-3x text-muted"></i>
                                                        <br>
                                                        <small>{{ basename($attachment) }}</small>
                                                    @endif
                                                    <br>
                                                    <a href="{{ asset('storage/' . $attachment) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-primary mt-2">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                @if($report->status != 'approved')
                                    <form method="POST"
                                          action="{{ route('admin.field-agents.reports.approve', $report->id) }}"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Are you sure you want to approve this report and mark task as completed?')">
                                            <i class="fas fa-check"></i> Approve Report
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                        <i class="fas fa-times"></i> Reject Report
                                    </button>
                                @else
                                    <span class="badge badge-success p-3">
                                        <i class="fas fa-check-circle"></i> This report has been approved
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.field-agents.reports.reject', $report->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Report</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rejection_reason">Reason for rejection:</label>
                            <textarea name="rejection_reason" id="rejection_reason"
                                      class="form-control" rows="4"
                                      placeholder="Please provide reason for rejecting this report..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
