@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Add Package</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Test Configuration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.test-packages') }}">Test Packages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-plus-circle me-2"></i>Add Package</h3>
                </div>
                    <form action="{{ route('admin.test-packages.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div style="padding: 15px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Package Name <span style="color: #777777;">*</span></label>
                                            <input type="text" name="package_name" class="form-control"
                                                value="{{ old('package_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Sample Type <span style="color: #777777;">*</span></label>
                                            <select name="sample_type" class="form-select" required>
                                                <option value="">-- Select Sample Type --</option>
                                                @foreach ($sampleTypes as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ old('sample_type') == $type->id ? 'selected' : '' }}>
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
                                                value="{{ old('price') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Reporting Time</label>
                                            <input type="text" name="reporting_time" class="form-control"
                                                value="{{ old('reporting_time') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Parameters</label>
                                            <select id="paramSelect" class="form-select">
                                                <option value="">-- Select Parameter --</option>
                                                @foreach ($parameters as $param)
                                                    <option value="{{ $param->id }}"
                                                        {{ in_array($param->id, old('parameters', $package->parameters ?? [])) ? 'style=display:none;' : '' }}>
                                                        {{ $param->parameter }} ({{ $param->symbol }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Click to select parameters</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Selected Parameters:</label>
                                            <div id="selectedParams" class="border p-2" style="min-height:50px;"></div>
                                        </div>

                                        <input type="hidden" name="parameters" id="parametersInput"
                                            value='{{ json_encode(old('parameters', $package->parameters ?? [])) }}'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-save me-1"></i> Save
                                </button>
                                <a href="{{ route('admin.test-packages') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const paramSelect = document.getElementById('paramSelect');
        const selectedParamsDiv = document.getElementById('selectedParams');
        const parametersInput = document.getElementById('parametersInput');

        // Load pre-selected parameters if editing
        let selectedParams = JSON.parse(parametersInput.value || '[]');

        // Prefill div
        selectedParams.forEach(id => {
            const option = paramSelect.querySelector(`option[value='${id}']`);
            if (option) option.style.display = 'none';
            const text = option ? option.text : id;
            const span = document.createElement('span');
            span.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
            span.textContent = text;
            span.dataset.id = id;
            span.style.cursor = 'pointer';
            span.title = 'Click to remove';
            selectedParamsDiv.appendChild(span);
        });

        // Add new parameter
        paramSelect.addEventListener('change', function() {
            const selectedId = this.value;
            if (!selectedId || selectedParams.includes(selectedId)) return;

            const selectedText = this.options[this.selectedIndex].text;

            selectedParams.push(selectedId);
            parametersInput.value = JSON.stringify(selectedParams);

            const span = document.createElement('span');
            span.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
            span.textContent = selectedText;
            span.dataset.id = selectedId;
            span.style.cursor = 'pointer';
            span.title = 'Click to remove';
            selectedParamsDiv.appendChild(span);

            this.options[this.selectedIndex].style.display = 'none';
            this.value = '';
        });

        // Remove parameter
        selectedParamsDiv.addEventListener('click', function(e) {
            if (e.target.tagName === 'SPAN') {
                const id = e.target.dataset.id;
                selectedParams = selectedParams.filter(i => i != id);
                parametersInput.value = JSON.stringify(selectedParams);

                const option = paramSelect.querySelector(`option[value='${id}']`);
                if (option) option.style.display = 'block';

                e.target.remove();
            }
        });
    </script>
@endsection
