@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-person me-2"></i> Farmer Details: {{ $farmer->fullname }}</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('agent.farmers') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Farmers
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="card-body">
                        <div class="row">
                            <!-- Farmer Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i> Farmer Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table datatable table-bordered">
                                            <tr>
                                                <th style="width: 140px;">Full Name</th>
                                                <td>{{ $farmer->fullname }}</td>
                                            </tr>
                                            <tr>
                                                <th>Username</th>
                                                <td>{{ $farmer->username ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>{{ $farmer->gender ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Contact</th>
                                                <td>
                                                    {{ $farmer->contact }}
                                                    @if($farmer->whatsapp)
                                                        <br><small style="color: #777777;">WhatsApp: {{ $farmer->whatsapp }}</small>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>
                                                    @if($farmer->user)
                                                        {{ $farmer->user->email }}
                                                    @else
                                                        {{ $farmer->email ?? 'No email' }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>
                                                    @if($farmer->address)
                                                        {{ $farmer->address }}<br>
                                                        {{ $farmer->postoffice ?? '' }}<br>
                                                        {{ $farmer->district ?? '' }}, {{ $farmer->state ?? '' }}<br>
                                                        {{ $farmer->pincode ?? '' }}
                                                    @else
                                                        <span class="text-muted">No address information</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Farming Information -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-flower1 me-2"></i> Farming Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table datatable table-bordered">
                                            <tr>
                                                <th style="width: 180px;">Crops Grown</th>
                                                <td>{{ $farmer->crop_grown ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Land Area</th>
                                                <td>{{ $farmer->land_area_total ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cultivated Land</th>
                                                <td>{{ $farmer->land_area_cultivated ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Farming Since</th>
                                                <td>{{ $farmer->farming_since ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Technology Used</th>
                                                <td>{{ $farmer->technology_intervention ?? 'Not specified' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Future Plans</th>
                                                <td>{{ $farmer->future_plans ?? 'Not specified' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fields Section -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-geo-alt me-2"></i> Fields</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($farmer->fields && $farmer->fields->count() > 0)
                                            <div class="table-responsive">
                                                <table class=" datatable table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Field Name</th>
                                                            <th>Location</th>
                                                            <th>Area</th>
                                                            <th>Soil Type</th>
                                                            <th>Crops</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($farmer->fields as $field)
                                                            <tr>
                                                                <td>{{ $field->field_name }}</td>
                                                                <td>{{ $field->location ?? 'Not specified' }}</td>
                                                                <td>{{ $field->field_area ?? 'Not specified' }}</td>
                                                                <td>{{ $field->soil_type ?? 'Not specified' }}</td>
                                                                <td>
                                                                    @if($field->crops && $field->crops->count() > 0)
                                                                        @foreach($field->crops as $crop)
                                                                            <span class="badge badge-success">{{ $crop->name }}</span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="text-muted">No crops</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('agent.fields.show', $field->id) }}"
                                                                       class="btn btn-sm btn-info">
                                                                        <i class="fas fa-eye"></i> View
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info">This farmer has no fields registered yet.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Section -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-warning text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-list-task me-2"></i> Tasks</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($tasks && $tasks->count() > 0)
                                            <div class="table-responsive">
                                                <table class="datatable table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th>Description</th>
                                                            <th>Field</th>
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
                                                                    @if($task->field)
                                                                        {{ $task->field->field_name }}
                                                                    @else
                                                                        <span class="text-muted">No field</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No deadline' }}
                                                                    @if($task->due_date && $task->due_date < now() && $task->status != 'completed')
                                                                        <span class="badge badge-danger">Overdue</span>
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
                                            <div class="alert alert-info">No tasks assigned for this farmer.</div>
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
                        <div class="form-group">
                            <label for="notes">Notes <span style="color: #777777;">*</span></label>
                            <textarea name="notes" id="notes" class="form-control" rows="5"
                                      placeholder="Enter detailed notes about the task completion" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="attachments">Attachments (Photos, Documents)</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                            <small class="form-text text-muted">Accepted formats: JPG, PNG, PDF, DOC, DOCX. Maximum size: 5MB each.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Complete Task</button>
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
            });
        });
    </script>
@endsection
