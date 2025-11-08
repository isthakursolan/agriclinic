@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Farmer Assignments</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Farmer Assignments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-list-ul me-2"></i> Farmer Assignments</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.field-agents.assign-form') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-person-plus me-2"></i> New Assignment
                            </a>
                            <a href="{{ route('admin.field-agents') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> Back to Agents
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="myDataTable" class="datatable display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>#</th>
                                <th>Field Agent</th>
                                <th>Farmer</th>
                                <th>Farmer Contact</th>
                                <th>Assignment Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $assignment->fieldAgent->name }}
                                        @if($assignment->fieldAgent->profile)
                                            <br><small class="text-muted">{{ $assignment->fieldAgent->profile->fullname }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $assignment->farmer->fullname }}</td>
                                    <td>
                                        {{ $assignment->farmer->contact }}
                                        @if($assignment->farmer->whatsapp)
                                            <br><small style="color: #777777;">WhatsApp: {{ $assignment->farmer->whatsapp }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $assignment->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($assignment->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @elseif($assignment->status == 'completed')
                                            <span class="badge badge-primary">Completed</span>
                                        @else
                                            <span class="badge badge-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form method="POST"
                                              action="{{ route('admin.field-agents.unassign', [$assignment->farmer->id, $assignment->field_agent_id]) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to unassign this farmer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-person-x"></i>
                                            </button>
                                        </form>
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
            $('#myDataTable').DataTable();
        });
    </script>
@endsection
