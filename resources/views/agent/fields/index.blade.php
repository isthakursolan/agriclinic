@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Assigned Fields</h3>
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
                        @if($fields->count() > 0)
                            <table id="fieldsTable" class="datatable display table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Field Name</th>
                                        <th>Farmer</th>
                                        <th>Land Profile</th>
                                        <th>Area</th>
                                        <th>Soil Type</th>
                                        <th>Irrigation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fields as $field)
                                        <tr>
                                            <td>{{ $field->field_name }}</td>
                                            <td>
                                                @if($field->farmer)
                                                    <a href="{{ route('agent.farmers.show', $field->farmer_id) }}">
                                                        {{ $field->farmer->fullname }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">No farmer assigned</span>
                                                @endif
                                            </td>
                                            <td>{{ $field->land_profile ?? 'Not specified' }}</td>
                                            <td>{{ $field->field_area ?? 'Not specified' }}</td>
                                            <td>{{ $field->soil_type ?? 'Not specified' }}</td>
                                            <td>{{ $field->irrigation_system ?? 'Not specified' }}</td>
                                            <td>
                                                <a href="{{ route('agent.fields.show', $field->id) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i> You don't have any fields assigned to you yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('#fieldsTable').DataTable();
        });
    </script>
@endsection
