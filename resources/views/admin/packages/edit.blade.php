@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Update Package</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Test Configuration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.test-packages') }}">Test Packages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-pencil-square me-2"></i>Update Package</h3>
                </div>
                    <form action="{{ route('admin.test-packages.update', $package->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div style="padding: 15px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Package Name <span style="color: #777777;">*</span></label>
                                            <input type="text" name="package_name" class="form-control"
                                                value="{{ old('package_name', $package->package_name) }}" required>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Sample Type <span style="color: #777777;">*</span></label>
                                        <select name="sample_type" class="form-select" required>
                                            <option value="">-- Select Sample Type --</option>
                                            @foreach ($sampleTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ old('sample_type', $package->sample_type) == $type->id ? 'selected' : '' }}>
                                                    {{ $type->e_type }} ({{ $type->h_type }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Price <span style="color: #777777;">*</span></label>
                                        <input type="number" name="price" class="form-control"
                                            value="{{ old('price', $package->price) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Reporting Time</label>
                                        <input type="text" name="reporting_time" class="form-control"
                                            value="{{ old('reporting_time', $package->reporting_time) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Parameters</label>
                                        <select id="paramSelect" class="form-select">
                                            <option value="">-- Select Parameter --</option>
                                            @foreach ($parameters as $param)
                                                @if (!in_array($param->id, json_decode($package->parameters)))
                                                    <option value="{{ $param->id }}">{{ $param->parameter }}
                                                        ({{ $param->symbol }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Click to select parameters</small>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Selected Parameters:</label>
                                            <div id="selectedParams" class="border p-2" style="min-height:50px;">
                                                @foreach (json_decode($package->parameters) as $paramId)
                                                    @php
                                                        $paramObj = $parameters->firstWhere('id', $paramId);
                                                    @endphp
                                                    @if ($paramObj)
                                                        <span class="badge bg-success m-1" data-id="{{ $paramObj->id }}">
                                                            {{ $paramObj->parameter }}
                                                            <button type="button"
                                                                class="btn-close btn-close-white btn-sm removeParam"></button>
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <input type="hidden" name="parameters" id="parametersInput"
                                                value="{{ $package->parameters }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="bi bi-save me-1"></i> Update Package
                                    </button>
                                    <a href="{{ route('admin.test-packages') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const paramSelect = document.getElementById('paramSelect');
        const selectedParams = document.getElementById('selectedParams');
        const parametersInput = document.getElementById('parametersInput');

        // Add selected parameter to div
        paramSelect.addEventListener('change', function() {
            const selectedId = this.value;
            if (!selectedId) return;

            const selectedText = this.options[this.selectedIndex].text;

            // Append badge
            const badge = document.createElement('span');
            badge.className = 'badge bg-success m-1';
            badge.dataset.id = selectedId;
            badge.innerHTML =
                `${selectedText} <button type="button" class="btn-close btn-close-white btn-sm removeParam"></button>`;
            selectedParams.appendChild(badge);

            // Update hidden input
            let current = JSON.parse(parametersInput.value || '[]');
            current.push(parseInt(selectedId));
            parametersInput.value = JSON.stringify(current);

            // Remove from select
            this.options[this.selectedIndex].remove();
        });

        // Remove parameter from div
        selectedParams.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeParam')) {
                const badge = e.target.parentElement;
                const id = parseInt(badge.dataset.id);
                const text = badge.textContent.replace('×', '').trim();

                // Remove badge
                badge.remove();

                // Update hidden input
                let current = JSON.parse(parametersInput.value || '[]');
                current = current.filter(i => i !== id);
                parametersInput.value = JSON.stringify(current);

                // Add back to select
                const option = document.createElement('option');
                option.value = id;
                option.text = text;
                paramSelect.appendChild(option);
            }
        });
    </script>
@endsection
