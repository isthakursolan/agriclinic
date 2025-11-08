@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Field Details: {{ $field->field_name }}</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('agent.fields') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Fields
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card-body">
                        <div class="row">
                            <!-- Field Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i> Field Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 160px;">Field Name</th>
                                                <td>{{ $field->field_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Land Profile</th>
                                                <td>{{ $field->land_profile ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Field Area</th>
                                                <td>{{ $field->field_area ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Soil Type</th>
                                                <td>{{ $field->soil_type ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Field Type</th>
                                                <td>{{ $field->type_of_field ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Road Connectivity</th>
                                                <td>{{ $field->road_connectivity ?? 'Not specified' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Irrigation & Location Info -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-droplet me-2"></i> Irrigation & Location</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 160px;">Irrigation System</th>
                                                <td>{{ $field->irrigation_system ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Irrigation Source</th>
                                                <td>{{ $field->source_of_irrigation ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Latitude</th>
                                                <td>{{ $field->field_latitude ?? 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Longitude</th>
                                                <td>{{ $field->field_longitude ?? 'Not provided' }}</td>
                                            </tr>
                                            @if($field->field_latitude && $field->field_longitude)
                                            <tr>
                                                <th>Map Link</th>
                                                <td>
                                                    <a href="https://maps.google.com/?q={{ $field->field_latitude }},{{ $field->field_longitude }}"
                                                       target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-geo-alt me-2"></i> View on Map
                                                    </a>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Farmer Information -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-warning text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-person me-2"></i> Farmer Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 120px;">Name</th>
                                                <td>
                                                    <a href="{{ route('agent.farmers.show', $field->farmer->id) }}">
                                                        {{ $field->farmer->fullname }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Contact</th>
                                                <td>{{ $field->farmer->contact }}</td>
                                            </tr>
                                            <tr>
                                                <th>WhatsApp</th>
                                                <td>{{ $field->farmer->whatsapp ?? 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>
                                                    @if($field->farmer->user)
                                                        {{ $field->farmer->user->email }}
                                                    @else
                                                        {{ $field->farmer->email ?? 'No email' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Field Description & Map -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-file-text me-2"></i> Description & Map</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($field->description)
                                            <h6>Description:</h6>
                                            <p>{{ $field->description }}</p>
                                        @endif

                                        @if($field->field_boundary)
                                            <h6>Field Boundary:</h6>
                                            <p>{{ $field->field_boundary }}</p>
                                        @endif

                                        @if($field->map_image)
                                            <h6>Map Image:</h6>
                                            <img src="{{ asset('storage/' . $field->map_image) }}"
                                                 class="img-fluid"
                                                 alt="Field Map"
                                                 style="max-height: 200px;">
                                        @endif

                                        @if(!$field->description && !$field->field_boundary && !$field->map_image)
                                            <div class="alert alert-info">No additional information available.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Section -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-danger text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-list-task me-2"></i> Tasks for this Field</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($tasks && $tasks->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>Due Date</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($tasks as $task)
                                                            <tr>
                                                                <td>{{ $task->title }}</td>
                                                                <td>{{ Str::limit($task->description, 50) }}</td>
                                                                <td>
                                                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No deadline' }}
                                                                    @if($task->due_date && $task->due_date < now() && $task->status != 'completed')
                                                                        <br><span class="badge badge-danger">Overdue</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($task->status == 'pending')
                                                                        <span class="badge badge-warning text-dark">Pending</span>
                                                                    @elseif($task->status == 'in_progress')
                                                                        <span class="badge badge-info text-dark">In Progress</span>
                                                                    @elseif($task->status == 'completed')
                                                                        <span class="badge badge-success">Completed</span>
                                                                    @else
                                                                        <span class="badge badge-secondary">{{ ucfirst($task->status) }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($task->status == 'pending')
                                                                        <form method="POST" action="{{ route('agent.tasks.start', $task->id) }}" class="d-inline">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-sm btn-info" title="Start Task">
                                                                                <i class="fas fa-play"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endif

                                                                    @if($task->status != 'completed')
                                                                        <button type="button" class="btn btn-sm btn-success"
                                                                                data-toggle="modal"
                                                                                data-target="#completeTaskModal"
                                                                                data-task-id="{{ $task->id }}"
                                                                                data-task-title="{{ $task->title }}">
                                                                            <i class="fas fa-check"></i> Complete
                                                                        </button>
                                                                    @else
                                                                        @if($task->reports && $task->reports->count() > 0)
                                                                            <a href="{{ route('agent.reports.show', $task->reports->first()->id) }}"
                                                                               class="btn btn-sm btn-primary">
                                                                                <i class="bi bi-file-text me-2"></i> View Report
                                                                            </a>
                                                                        @else
                                                                            <span class="badge badge-success">Completed</span>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info">No tasks assigned for this field.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Complete Task Modal -->
    <div class="modal fade" id="completeTaskModal" tabindex="-1" role="dialog" aria-labelledby="completeTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="completeTaskForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="completeTaskModalLabel">Complete Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i> Please provide detailed notes about the work completed and any observations made.
                        </div>
                        <div class="form-group">
                            <label for="notes">Task Completion Notes <span style="color: #777777;">*</span></label>
                            <textarea name="notes" id="notes" class="form-control" rows="6"
                                      placeholder="Describe what was done, observations made, any issues encountered, recommendations for future..." required></textarea>
                            <small class="form-text text-muted">Minimum 10 characters required.</small>
                        </div>
                        <div class="form-group">
                            <label for="attachments">Attachments (Photos, Documents)</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <small class="form-text text-muted">
                                Accepted formats: JPG, PNG, PDF, DOC, DOCX. Maximum size: 5MB each.
                                <br>Please include photos of the work completed, field conditions, or any relevant documentation.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Complete Task & Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Set up the task completion form
            $('#completeTaskModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var taskId = button.data('task-id');
                var taskTitle = button.data('task-title');
                var modal = $(this);

                modal.find('.modal-title').text('Complete Task: ' + taskTitle);
                modal.find('#completeTaskForm').attr('action', '{{ url("agent/tasks") }}/' + taskId + '/complete');

                // Clear previous form data
                modal.find('#notes').val('');
                modal.find('#attachments').val('');
            });

            // Form validation
            $('#completeTaskForm').on('submit', function(e) {
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
