@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-plus"></i> Assign Farmer to Field Agent</h3>
                    </div>
                    <form action="{{ route('admin.field-agents.assign-farmer') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="agent_id">Select Field Agent <span class="text-danger">*</span></label>
                                        <select name="agent_id" id="agent_id" class="form-control" required>
                                            <option value="">Choose Field Agent</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}"
                                                    {{ request('agent') == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }}
                                                    @if($agent->profile)
                                                        ({{ $agent->profile->fullname }})
                                                    @endif
                                                    - {{ $agent->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('agent_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="farmer_id">Select Farmer <span class="text-danger">*</span></label>
                                        <select name="farmer_id" id="farmer_id" class="form-control" required>
                                            <option value="">Choose Farmer</option>
                                            @foreach($farmers as $farmer)
                                                <option value="{{ $farmer->id }}">
                                                    {{ $farmer->fullname }} ({{ $farmer->contact }})
                                                    @if($farmer->user)
                                                        - {{ $farmer->user->email }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('farmer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id">Select Field (Optional)</label>
                                        <select name="field_id" id="field_id" class="form-control" disabled>
                                            <option value="">First select a farmer</option>
                                        </select>
                                        <small class="text-muted">Fields will appear after selecting a farmer</small>
                                        @error('field_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Assign Farmer
                            </button>
                            <a href="{{ route('admin.field-agents') }}" class="btn btn-secondary">
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
            // Initialize Select2 for better dropdowns
            $('#agent_id, #farmer_id, #field_id').select2({
                allowClear: true
            });

            // Load fields when farmer is selected
            $('#farmer_id').change(function() {
                var farmerId = $(this).val();
                var fieldSelect = $('#field_id');

                if (farmerId) {
                    // Enable field dropdown and show loading
                    fieldSelect.prop('disabled', false);
                    fieldSelect.html('<option value="">Loading fields...</option>');

                    // Fetch fields for selected farmer
                    $.get('/admin/field-agents/get-fields/' + farmerId)
                        .done(function(data) {
                            fieldSelect.html('<option value="">Select Field (Optional)</option>');

                            if (data.length > 0) {
                                $.each(data, function(index, field) {
                                    fieldSelect.append('<option value="' + field.id + '">' +
                                                     field.field_name + ' (' + field.location + ')</option>');
                                });
                            } else {
                                fieldSelect.html('<option value="">No fields found for this farmer</option>');
                            }
                        })
                        .fail(function() {
                            fieldSelect.html('<option value="">Error loading fields</option>');
                        });
                } else {
                    // Disable field dropdown if no farmer selected
                    fieldSelect.prop('disabled', true);
                    fieldSelect.html('<option value="">First select a farmer</option>');
                }
            });
        });
    </script>
@endsection
