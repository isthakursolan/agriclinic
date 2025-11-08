@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-list-task me-2"></i> Create Task for Field Agent</h3>
                    </div>
                    <form action="{{ route('admin.field-agents.store-task') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div style="padding: 15px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="field_agent_id" class="form-label fw-semibold">Select Field Agent <span
                                                    style="color: #777777;">*</span></label>
                                            <select name="field_agent_id" id="field_agent_id" class="form-select" required>
                                            <option value="">Choose Field Agent</option>
                                            @foreach ($agents as $agent)
                                                <option value="{{ $agent->id }}"
                                                    {{ request('agent') == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }}
                                                    @if ($agent->profile)
                                                        ({{ $agent->profile->fullname }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('field_agent_id')
                                            <span style="color: #777777;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="farmer_id" class="form-label fw-semibold">Select Farmer (Optional)</label>
                                            <select name="farmer_id" id="farmer_id" class="form-select">
                                            <option value="">Choose Farmer</option>
                                            @foreach ($farmers as $farmer)
                                                <option value="{{ $farmer->id }}">
                                                    {{ $farmer->fullname }} ({{ $farmer->contact }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('farmer_id')
                                            <span style="color: #777777;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="field_id" class="form-label fw-semibold">Select Field (Optional)</label>
                                            <select name="field_id" id="field_id" class="form-select" disabled>
                                            <option value="">First select a farmer</option>
                                        </select>
                                        <small class="text-muted">Fields will appear after selecting a farmer</small>
                                        @error('field_id')
                                            <span style="color: #777777;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="due_date" class="form-label fw-semibold">Due Date <span style="color: #777777;">*</span></label>
                                            <input type="date" name="due_date" id="due_date" class="form-control"
                                                min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        @error('due_date')
                                            <span style="color: #777777;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label fw-semibold">Task Title <span style="color: #777777;">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Enter task title" required>
                                        @error('title')
                                            <span style="color: #777777;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-semibold">Task Description <span style="color: #777777;">*</span></label>
                                            <textarea name="description" id="description" class="form-control" rows="4"
                                                placeholder="Enter detailed task description" required></textarea>
                                            @error('description')
                                                <span style="color: #777777;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="bi bi-save me-1"></i> Create Task
                                    </button>
                                    <a href="{{ route('admin.field-agents') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const farmerSelect = document.getElementById('farmer_id');
            const fieldSelect = document.getElementById('field_id');

            farmerSelect.addEventListener('change', function() {
                const farmerId = this.value;
                console.log('Selected farmer ID:', farmerId);

                if (!farmerId) {
                    console.log('No farmer selected');
                    fieldSelect.disabled = true;
                    fieldSelect.innerHTML = '<option value="">First select a farmer</option>';
                    return;
                }

                fieldSelect.disabled = true;
                fieldSelect.innerHTML = '<option value="">Loading fields...</option>';

                // Create a fetch request to get fields
                fetch('/admin/field-agents/get-fields/' + farmerId, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    fieldSelect.disabled = false;

                    if (data && data.length > 0) {
                        console.log(data);

                        fieldSelect.innerHTML = '<option value="">Select Field (Optional)</option>';
                        data.forEach(field => {
                            const option = document.createElement('option');
                            option.value = field.id;
                            option.textContent = field.field_name;
                            fieldSelect.appendChild(option);
                        });
                        console.log("Fields loaded:", data);
                    } else {
                        fieldSelect.innerHTML = '<option value="">No fields available for this farmer</option>';
                        console.log("No fields found for farmer ID:", farmerId);
                    }
                })
                .catch(error => {
                    console.error("Error loading fields:", error);
                    fieldSelect.innerHTML = '<option value="">Error loading fields</option>';
                    fieldSelect.disabled = true;
                });
            });

            // If farmer is pre-selected, load fields on page load
            if (farmerSelect.value) {
                farmerSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
