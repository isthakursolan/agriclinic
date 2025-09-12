@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Report for Task</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('agent.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('agent.tasks') }}">Tasks</a></li>
                            <li class="breadcrumb-item active">Create Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-alt"></i> Report for: {{ $task->title }}</h3>
                    </div>
                    <form method="POST" action="{{ route('agent.reports.store', $task->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> You are completing the task: <strong>{{ $task->title }}</strong>.
                                <br>
                                Please provide detailed notes and any relevant attachments.
                            </div>

                            <div class="form-group">
                                <label for="notes">Task Completion Notes <span class="text-danger">*</span></label>
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="6"
                                          placeholder="Describe what was done, observations made, any issues encountered, recommendations for the future..." required>{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Minimum 10 characters required.</small>
                            </div>

                            <div class="form-group">
                                <label for="attachments">Attachments (Photos, Documents)</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control @error('attachments.*') is-invalid @enderror" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                @error('attachments.*')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    Accepted formats: JPG, PNG, PDF, DOC, DOCX. Maximum size: 5MB each.
                                </small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Complete Task & Submit Report
                            </button>
                            <a href="{{ route('agent.tasks') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                var notes = $('#notes').val().trim();
                if (notes.length < 10) {
                    e.preventDefault();
                    alert('Please provide more detailed notes (at least 10 characters).');
                    $('#notes').focus();
                }
            });
        });
    </script>
@endsection
