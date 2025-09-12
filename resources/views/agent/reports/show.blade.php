@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-alt"></i> Report Details</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            @if($report->task->status != 'completed')
                                <a href="{{ route('agent.reports.edit', $report->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Report
                                </a>
                            @endif
                            <a href="{{ route('agent.reports') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Reports
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card-body">
                        <div class="row">
                            <!-- Task Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0"><i class="fas fa-tasks"></i> Task Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 120px;">Title:</th>
                                                <td>{{ $report->task->title }}</td>
                                            </tr>
                                            <tr>
                                                <th>Description:</th>
                                                <td>{{ $report->task->description }}</td>
                                            </tr>
                                            <tr>
                                                <th>Due Date:</th>
                                                <td>{{ $report->task->due_date ? $report->task->due_date->format('M d, Y') : 'No deadline' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>
                                                    @if($report->task->status == 'completed')
                                                        <span class="badge badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending Review</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Report Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Report Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 140px;">Submitted:</th>
                                                <td>{{ $report->submitted_at->format('M d, Y H:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Farmer:</th>
                                                <td>
                                                    @if($report->task->farmer)
                                                        <a href="{{ route('agent.farmers.show', $report->task->farmer->id) }}">
                                                            {{ $report->task->farmer->fullname }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No farmer assigned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Field:</th>
                                                <td>
                                                    @if($report->task->field)
                                                        <a href="{{ route('agent.fields.show', $report->task->field->id) }}">
                                                            {{ $report->task->field->field_name }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No field assigned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Notes -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="card-title mb-0"><i class="fas fa-sticky-note"></i> Report Notes</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $report->notes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attachments -->
                        @if($report->attachments)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-warning text-white">
                                        <h5 class="card-title mb-0"><i class="fas fa-paperclip"></i> Attachments</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach(json_decode($report->attachments, true) as $index => $attachment)
                                                <div class="col-md-3 mb-3">
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
                                                            <div class="mt-2">
                                                                <a href="{{ asset('storage/' . $attachment) }}"
                                                                   target="_blank"
                                                                   class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-download"></i> View
                                                                </a>
                                                                @if($report->task->status != 'completed')
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-danger delete-attachment"
                                                                            data-report-id="{{ $report->id }}"
                                                                            data-attachment-index="{{ $index }}">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            // Delete attachment functionality
            $('.delete-attachment').click(function() {
                if (!confirm('Are you sure you want to delete this attachment?')) {
                    return;
                }

                var reportId = $(this).data('report-id');
                var attachmentIndex = $(this).data('attachment-index');
                var button = $(this);

                $.ajax({
                    url: '{{ url("agent/reports") }}/' + reportId + '/attachments/' + attachmentIndex,
                    method: 'DELETE',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            button.closest('.col-md-3').remove();
                        } else {
                            alert('Failed to delete attachment');
                        }
                    },
                    error: function() {
                        alert('Error occurred while deleting attachment');
                    }
                });
            });
        });
    </script>
@endsection
