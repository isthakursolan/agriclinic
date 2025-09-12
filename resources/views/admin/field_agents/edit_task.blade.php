@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Edit Task</h3>
                    </div>
                    <form action="{{ route('admin.field-agents.update-task', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_agent_id">Field Agent <span class="text-danger">*</span></label>
                                        <select name="field_agent_id" id="field_agent_id" class="form-control" required>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}" {{ $task->field_agent_id == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }}
                                                    @if($agent->profile)
                                                        ({{ $agent->profile->fullname }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('field_agent_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Task Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $task->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="farmer_id">Farmer (Optional)</label>
                                        <select name="farmer_id" id="farmer_id" class="form-control">
                                            <option value="">No Farmer</option>
                                            @foreach($farmers as $farmer)
                                                <option value="{{ $farmer->id }}" {{ $task->farmer_id == $farmer->id ? 'selected' : '' }}>
                                                    {{ $farmer->fullname }} ({{ $farmer->contact }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('farmer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id">Field (Optional)</label>
                                        <select name="field_id" id="field_id" class="form-control">
                                            <option value="">No Field</option>
                                            @foreach($fields as $field)
                                                <option value="{{ $field->id }}" {{ $task->field_id == $field->id ? 'selected' : '' }}>
                                                    {{ $field->field_name }}
                                                    @if($field->farmer)
                                                        ({{ $field->farmer->fullname }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('field_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Task Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ $task->title }}" required>
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                        <input type="date" name="due_date" id="due_date" class="form-control"
                                               value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}" required>
                                        @error('due_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Task Description <span class="text-danger">*</span></label>
                                        <textarea name="description" id="description" class="form-control" rows="4" required>{{ $task->description }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Task
                            </button>
                            <a href="{{ route('admin.field-agents.tasks', $task->field_agent_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#field_agent_id, #farmer_id, #field_id, #status').select2({
                allowClear: true
            });

            // Load fields when farmer changes (for edit form)
            $('#farmer_id').change(function() {
                var farmerId = $(this).val();
                var fieldSelect = $('#field_id');
                var currentFieldId = {{ $task->field_id ?? 'null' }};

                if (farmerId) {
                    $.get('/admin/field-agents/get-fields/' + farmerId)
                        .done(function(data) {
                            fieldSelect.html('<option value="">No Field</option>');

                            if (data.length > 0) {
                                $.each(data, function(index, field) {
                                    var selected = (field.id == currentFieldId) ? 'selected' : '';
                                    fieldSelect.append('<option value="' + field.id + '" ' + selected + '>' +
                                                     field.field_name + ' (' + field.location + ')</option>');
                                });
                            }
                        });
                } else {
                    fieldSelect.html('<option value="">No Field</option>');
                }
            });

            // Trigger change on page load if farmer is selected
            if ($('#farmer_id').val()) {
                $('#farmer_id').trigger('change');
            }
        });
    </script>
@endsection
