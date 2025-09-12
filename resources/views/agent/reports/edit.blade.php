@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Edit Report</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('agent.reports.show', $report->id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Report
                            </a>
                            <a href="{{ route('agent.reports') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Reports
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('agent.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <!-- Task Information (Read-only) -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="card-title mb-0"><i class="fas fa-tasks"></i> Task Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th style="width: 120px;">Title:</th>
                                                            <td>{{ $report->task->title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Description:</th>
                                                            <td>{{ $report->task->description }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th style="width: 120px;">Farmer:</th>
                                                            <td>
                                                                @if($report->task->farmer)
                                                                    {{ $report->task->farmer->fullname }}
                                                                @else
                                                                    <span class="text-muted">No farmer assigned</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Field:</th>
                                                            <td>
                                                                @if($report->task->field)
                                                                    {{ $report->task->field->field_name }}
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
                                </div>
                            </div>

                            <!-- Report Notes -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Report Notes <span class="text-danger">*</span></label>
                                        <textarea name="notes" id="notes" class="form-control" rows="8"
                                                  placeholder="Describe what was done, observations made, any issues encountered, recommendations for future..." required>{{ old('notes', $report->notes) }}</textarea>
                                        <small class="form-text text-muted">Minimum 10 characters required.</small>
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Current Attachments -->
                            @if($report->attachments)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-secondary text-white">
                                            <h6 class="card-title mb-0"><i class="fas fa-paperclip"></i> Current Attachments</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach(json_decode($report->attachments, true) as $index => $attachment)
                                                    <div class="col-md-3 mb-3" id="attachment-{{ $index }}">
                                                        <div class="card">
                                                            <div class="card-body text-center">
                                                                @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <img src="{{ asset('storage/' . $attachment) }}"
                                                                         class="img-fluid"
                                                                         style="max-height: 150px;"
                                                                         alt="Report Image">
                                                                @else
                                                                    <i class="fas fa-file fa-2x text-muted"></i>
                                                                    <br>
                                                                    <small>{{ basename($attachment) }}</small>
                                                                @endif
                                                                <br>
                                                                <div class="mt-2">
                                                                    <a href="{{ asset('storage/' . $attachment) }}"
                                                                       target="_blank"
                                                                       class="btn btn-xs btn-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                            class="btn btn-xs btn-danger delete-attachment"
                                                                            data-report-id="{{ $report->id }}"
                                                                            data-attachment-index="{{ $index }}">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
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

                            <!-- Add New Attachments -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="attachments">Add New Attachments</label>
                                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        <small class="form-text text-muted">
                                            Accepted formats: JPG, PNG, PDF, DOC, DOCX. Maximum size: 5MB each.
                                            <br>New attachments will be added to existing ones.
                                        </small>
                                        @error('attachments.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Report
                            </button>
                            <a href="{{ route('agent.reports.show', $report->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
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
                var attachmentDiv = $('#attachment-' + attachmentIndex);

                $.ajax({
                    url: '{{ url("agent/reports") }}/' + reportId + '/attachments/' + attachmentIndex,
                    method: 'DELETE',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            attachmentDiv.fadeOut(300, function() {
                                $(this).remove();

                                // Check if no attachments left
                                if ($('.delete-attachment').length === 0) {
                                    $('.card-header:contains("Current Attachments")').parent().fadeOut();
                                }
                            });
                        } else {
                            alert('Failed to delete attachment');
                        }
                    },
                    error: function() {
                        alert('Error occurred while deleting attachment');
                    }
                });
            });

            // Form validation
            $('form').on('submit', function(e) {
                var notes = $('#notes').val().trim();
                if (notes.length < 10) {
                    e.preventDefault();
                    alert('Please provide more detailed notes (at least 10 characters).');
                    $('#notes').focus();
                    return false;
                }
            });
        });
    </script>
@endsection
