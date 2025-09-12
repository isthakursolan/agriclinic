@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tasks"></i> Tasks for {{ $agent->name }}
                            @if($agent->profile)
                                ({{ $agent->profile->fullname }})
                            @endif
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.field-agents.create-task') }}?agent={{ $agent->id }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New Task
                            </a>
                            <a href="{{ route('admin.field-agents') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Agents
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table id="tasksTable" class="datatable display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>Task Title</th>
                                <th>Farmer</th>
                                <th>Field</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>
                                        @if($task->farmer)
                                            {{ $task->farmer->fullname }}
                                        @else
                                            <span class="text-muted">Not assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->field)
                                            {{ $task->field->field_name }}
                                        @else
                                            <span class="text-muted">Not assigned</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($task->description, 50) }}</td>
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
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $task->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.field-agents.edit-task', $task->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('admin.field-agents.destroy-task', $task->id) }}"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
            $('#tasksTable').DataTable({
                "order": [[ 4, "asc" ]] // Sort by due date by default
            });
        });
    </script>
@endsection
