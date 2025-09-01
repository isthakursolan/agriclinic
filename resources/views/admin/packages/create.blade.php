@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Add Package</h3>
                    </div>
                    <form action="{{ route('admin.packages.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Package Name</label>
                                        <input type="text" name="package_name" class="form-control"
                                            value="{{ old('package_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Sample Type</label>
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
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control"
                                            value="{{ old('price') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Reporting Time</label>
                                        <input type="text" name="reporting_time" class="form-control"
                                            value="{{ old('reporting_time') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Parameters</label>
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
                                        <label>Selected Parameters:</label>
                                        <div id="selectedParams" class="border p-2" style="min-height:50px;"></div>
                                    </div>

                                    <input type="hidden" name="parameters" id="parametersInput"
                                        value='{{ json_encode(old('parameters', $package->parameters ?? [])) }}'>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
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
