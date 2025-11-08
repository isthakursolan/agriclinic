@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-list-task me-2"></i> My Tasks</h3>
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
                        @if($tasks->count() > 0)
                            <!-- Task Filters -->
                            <div class="mb-3">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default filter-btn active" data-filter="all">All Tasks</button>
                                    <button type="button" class="btn btn-warning filter-btn" data-filter="pending">Pending</button>
                                    <button type="button" class="btn btn-info filter-btn" data-filter="in_progress">In Progress</button>
                                    <button type="button" class="btn btn-success filter-btn" data-filter="completed">Completed</button>
                                    <button type="button" class="btn btn-danger filter-btn" data-filter="overdue">Overdue</button>
                                </div>
                            </div>

                            <table id="tasksTable" class="datatable display table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Title</th>
                                        <th>Farmer</th>
                                        <th>Field</th>
                                        <th>Description</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr class="task-row"
                                            data-status="{{ $task->status }}"
                                            data-overdue="{{ ($task->due_date && $task->due_date < now() && $task->status != 'completed') ? 'yes' : 'no' }}">
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                @if($task->farmer)
                                                    <a href="{{ route('agent.farmers.show', $task->farmer->id) }}">
                                                        {{ $task->farmer->fullname }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">No farmer</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->field)
                                                    <a href="{{ route('agent.fields.show', $task->field->id) }}">
                                                        {{ $task->field->field_name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">No field</span>
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
                                                    <span class="badge badge-secondary">{{ ucfirst($task->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if($task->status == 'pending')
                                                        <form method="POST" action="{{ route('agent.tasks.start', $task->id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-info" title="Start Task">
                                                                <i class="fas fa-play"></i> Start
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($task->status == 'pending' || $task->status == 'in_progress')
                                                        <a href="{{ route('agent.reports.create', $task->id) }}" class="btn btn-sm btn-success" title="Complete Task">
                                                            <i class="fas fa-check"></i> Complete
                                                        </a>
                                                    @endif

                                                    @if($task->status == 'completed')
                                                        @if($task->reports && $task->reports->count() > 0)
                                                            <a href="{{ route('agent.reports.show', $task->reports->first()->id) }}"
                                                               class="btn btn-sm btn-primary" title="View Report">
                                                                <i class="bi bi-file-text me-2"></i> View Report
                                                            </a>
                                                        @else
                                                            <span class="badge badge-success">Completed</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> You don't have any tasks assigned to you yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#tasksTable').DataTable({
                "order": [[ 4, "asc" ]] // Sort by due date by default
            });

            // Task filtering
            $('.filter-btn').click(function() {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');

                var filter = $(this).data('filter');

                // Clear all previous searches
                table.columns().search('').draw();

                if (filter === 'all') {
                    // 'all' is default, do nothing extra
                } else if (filter === 'overdue') {
                    // Search for the "Overdue" badge text in the Due Date column (index 4)
                    table.column(4).search('Overdue').draw();
                } else {
                    // Search for the status text in the Status column (index 5)
                    // Use regex for exact word match
                    table.column(5).search('^' + filter + '$', true, false).draw();
                }
            });
        });
    </script>

@endsection
