@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users"></i> Assigned Farmers</h3>
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
                        @if($assignments->count() > 0)
                            <table id="farmersTable" class="datatable display table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Farmer Name</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Fields</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignments as $assignment)
                                        <tr>
                                            <td>
                                                {{ $assignment->farmer->fullname }}
                                                @if($assignment->farmer->username)
                                                    <br><small class="text-muted">{{ $assignment->farmer->username }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $assignment->farmer->contact }}
                                                @if($assignment->farmer->whatsapp)
                                                    <br><small class="text-success">WhatsApp: {{ $assignment->farmer->whatsapp }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($assignment->farmer->user)
                                                    {{ $assignment->farmer->user->email }}
                                                @else
                                                    {{ $assignment->farmer->email ?? 'No email' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($assignment->farmer->fields && $assignment->farmer->fields->count() > 0)
                                                    <span class="badge badge-info text-dark">{{ $assignment->farmer->fields->count() }} fields</span>
                                                @else
                                                    <span class="badge badge-warning text-dark">No fields</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($assignment->farmer->address)
                                                    {{ $assignment->farmer->address }}
                                                    @if($assignment->farmer->district)
                                                        <br>{{ $assignment->farmer->district }}, {{ $assignment->farmer->state ?? '' }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">No address</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($assignment->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @elseif($assignment->status == 'completed')
                                                    <span class="badge badge-primary">Completed</span>
                                                @else
                                                    <span class="badge badge-warning text-dark">{{ ucfirst($assignment->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('agent.farmers.show', $assignment->farmer->id) }}"
                                                    class="btn btn-sm btn-info" title="View Farmer Details">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> You don't have any farmers assigned to you yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#farmersTable').DataTable();
        });
    </script>
@endsection
