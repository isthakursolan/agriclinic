@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white">
                            <i class="bi bi-pencil-square me-2"></i>
                            {{ $sample ? 'Edit Sample for Sample Id : ' . $sample->id : 'Book Tests' }}
                        </h3>
                    </div>

                    <form action="{{ $sample ? route('user.samples.update', $sample->id) : route('user.sample.store') }}"
                        method="POST" enctype="multipart/form-data" id="sampleForm">
                        @csrf
                        @if ($sample)
                            @method('PUT')
                        @endif

                        <div class="card-body">
                            <div class="row">
                                <!-- Farmer -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="farmer_id">Farmer</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('fullname', $profile->fullname ?? '') }}" readonly>
                                        <input type="hidden" name="farmer_id"
                                            value="{{ old('farmer_id', $profile->id ?? '') }}">
                                    </div>
                                </div>

                                <!-- Sample Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sample_type">Sample Type</label>
                                        <select id="sample_type" name="sample_type" class="form-control" required>
                                            <option value="">Select Sample Type</option>
                                            @foreach ($sample_type as $type)
                                                <option value="{{ $type->id }}" data-size="{{ $type->sample_size }}"
                                                    {{ old('sample_type', $sample->sample_type ?? '') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->e_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id">Field</label>
                                        <select name="field_id" class="form-control" disabled>
                                            <option value="">Select Field</option>
                                            @foreach ($field as $f)
                                                <option value="{{ $f->id }}"
                                                    {{ old('field_id', $sample->field_id ?? '') == $f->id ? 'selected' : '' }}>
                                                    {{ $f->field_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Crop -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="crop_id">Crop</label>
                                        <select name="crop_id" class="form-control" disabled>
                                            <option value="">Select Crop</option>
                                            @foreach ($crop as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ old('crop_id', $sample->crop_id ?? '') == $c->id ? 'selected' : '' }}>
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Packages -->
                                @php
                                    $packageParams = json_decode($packages->parameters, true) ?? [];
                                @endphp

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="package_id">Package</label>
                                        // Package dropdown
                                        <select name="package_id" id="package_id" class="form-control">
                                            <option value="">Select Package</option>
                                            @foreach($packages as $package)
                                                <option value="{{ $package->id }}"
                                                    {{ $sample->package_id == $package->id ? 'selected' : '' }}
                                                    data-price="{{ $package->price }}"
                                                    data-parameters="{{ json_encode($package->parameters->pluck('id')) }}">
                                                    {{ $package->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                // Parameters display
                                <div id="selected_params">
                                    @foreach($sample->parameters as $parameter)
                                        <span class="badge badge-info" style="margin-right: 5px;">
                                            {{ $parameter->parameter }}
                                            <span class="remove-param" data-id="{{ $parameter->id }}" style="cursor: pointer;">×</span>
                                        </span>
                                    @endforeach
                                </div>

                                // JavaScript to handle package selection
                                document.getElementById('package_id').addEventListener('change', function() {
                                    const selectedPackage = this.options[this.selectedIndex];
                                    const paramIds = JSON.parse(selectedPackage.dataset.parameters || '[]');

                                    // Update selected parameters display
                                    document.getElementById('selected_params').innerHTML = '';
                                    paramIds.forEach(id => {
                                        // Add each parameter to display
                                    });

                                    // Update hidden input with parameter IDs
                                    document.getElementById('parameter_ids').value = paramIds.join(',');
                                });

                                    </div>
                                    <div id="selected_params">
                                        @foreach ($sample->parameters as $parameter)
                                            <span class="badge badge-info" style="margin-right: 5px;">
                                                {{ $parameter->name }}
                                                <span class="remove-param" data-id="{{ $parameter->id }}"
                                                    style="cursor: pointer;">×</span>
                                            </span>
                                        @endforeach
                                    </div>
                                    <input type="hidden" id="parameter_ids" name="parameter_ids[]"
                                        value="{{ $sample->parameters->pluck('id')->implode(',') }}">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parameters">Additional Parameters</label>
                                        <select id="parameters" class="form-control">
                                            <option value="">Select Additional Parameters</option>
                                            @foreach ($parameters as $parameter)
                                                @if (!$sample->parameters->contains($parameter->id))
                                                    <option value="{{ $parameter->id }}"
                                                        data-price="{{ $parameter->price }}">
                                                        {{ $parameter->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const packageSelect = document.getElementById('package_id');
                                        const paramSelect = document.getElementById('parameters');
                                        const selectedParamsDiv = document.getElementById('selected_params');
                                        const paramIdsInput = document.getElementById('parameter_ids');

                                        packageSelect.addEventListener('change', function() {
                                            const selectedPackage = this.options[this.selectedIndex];
                                            const paramIds = selectedPackage.dataset.parameters.split(',');

                                            // Update selected parameters display
                                            selectedParamsDiv.innerHTML = '';
                                            paramIds.forEach(id => {
                                                if (id) {
                                                    const param = [...paramSelect.options].find(o => o.value === id);
                                                    if (param) {
                                                        selectedParamsDiv.innerHTML +=
                                                            `<span class="badge badge-info" style="margin-right: 5px;">
                                                            ${param.textContent}
                                                            <span class="remove-param" data-id="${id}" style="cursor: pointer;">×</span>
                                                        </span>`;
                                                    }
                                                }
                                            });

                                            // Update hidden input with parameter IDs
                                            paramIdsInput.value = paramIds.join(',');
                                        });

                                        // Add additional parameters
                                        paramSelect.addEventListener('change', function() {
                                            const selectedParam = this.options[this.selectedIndex];
                                            if (!selectedParam.value) return;

                                            // Add to display
                                            selectedParamsDiv.innerHTML +=
                                                `<span class="badge badge-info" style="margin-right: 5px;">
                                                ${selectedParam.textContent}
                                                <span class="remove-param" data-id="${selectedParam.value}" style="cursor: pointer;">×</span>
                                            </span>`;

                                            // Update hidden input
                                            const currentIds = paramIdsInput.value ? paramIdsInput.value.split(',') : [];
                                            currentIds.push(selectedParam.value);
                                            paramIdsInput.value = currentIds.join(',');

                                            // Remove from dropdown
                                            this.remove(this.selectedIndex);
                                        });

                                        // Remove parameter
                                        selectedParamsDiv.addEventListener('click', function(e) {
                                            if (e.target.classList.contains('remove-param')) {
                                                const paramId = e.target.dataset.id;
                                                e.target.parentElement.remove();

                                                // Update hidden input
                                                const currentIds = paramIdsInput.value.split(',').filter(id => id !== paramId);
                                                paramIdsInput.value = currentIds.join(',');

                                                // Add back to dropdown if not from package
                                                const packageParams = packageSelect.options[packageSelect.selectedIndex].dataset
                                                    .parameters.split(',');
                                                if (!packageParams.includes(paramId)) {
                                                    const param = [...paramSelect.options].find(o => o.value === paramId);
                                                    if (param) {
                                                        const newOption = new Option(param.textContent, param.value);
                                                        newOption.dataset.price = param.dataset.price;
                                                        paramSelect.add(newOption);
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>

                                <button type="button" id="resetParamsBtn" class="btn btn-info btn-sm mt-2">
                                    Reset Parameters
                                </button>
                            </div>

                            <input type="hidden" id="final_params" name="parameters" value='@json(old('parameters', $sample ? $sample->parameters : []))'>

                            {{--  Parameters  --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parameters">Select Parameters</label>
                                    <select id="parameters" name="param" class="form-control">
                                        <option value="">Select Parameters</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Collection Method -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Collection Method</label>
                                    <select name="collection_method" class="form-control" required>
                                        <option value="self"
                                            {{ old('collection_method', $sample->collection_method ?? '') == 'self' ? 'selected' : '' }}>
                                            Self
                                        </option>
                                        <option value="field_agent"
                                            {{ old('collection_method', $sample->collection_method ?? '') == 'field_agent' ? 'selected' : '' }}>
                                            Field Agent
                                        </option>
                                        <option value="post"
                                            {{ old('collection_method', $sample->collection_method ?? '') == 'post' ? 'selected' : '' }}>
                                            Courier/Post
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity of Sample</label>
                                    <input type="text" id="quantity" name="quantity" class="form-control"
                                        value="{{ old('quantity', $sample->quantity ?? '') }}" readonly>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" id="amount" name="amount" class="form-control"
                                        value="{{ old('amount', $sample->amount ?? '') }}" readonly>
                                </div>
                            </div>

                            <!-- Concern -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Concern</label>
                                    <select id="concerns" name="concern" class="form-control">
                                        <option value="">Select Concern</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save"></i>
                                    {{ $sample ? 'Update Sample' : 'Submit' }}
                                </button>
                                <a href="{{ route('user.sample') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                </div>
                </form>
            </div>
    </div>
    </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sampleTypeSelect = document.getElementById('sample_type');
            const paramSelect = document.getElementById('parameters');
            const packageSelect = document.getElementById('packages');
            const selectedParamsDiv = document.getElementById('selected_params');
            const finalParamsInput = document.getElementById('final_params');
            const amountInput = document.getElementById('amount');
            const quantityInput = document.getElementById('quantity');
            const concernsSelect = document.getElementById('concerns');

            let selectedParamIds = [];
            let packageParamIds = [];

            // preload existing values if editing
            @if ($sample)
                const selectedParamIds = @json($sample->parameters ?? []);
                const existingPackage = {{ $sample->package_id ?? 'null' }};
                const existingConcern = "{{ $sample->concern ?? '' }}";
            @endif

            sampleTypeSelect.addEventListener('change', async function() {
                const sampleTypeId = this.value;
                const size = this.options[this.selectedIndex]?.dataset.size || '';
                quantityInput.value = size;

                if (!sampleTypeId) return;

                try {
                    const res = await fetch(`/user/sample-type/${sampleTypeId}/data`);
                    const data = await res.json();

                    // Parameters
                    paramSelect.innerHTML = '<option value="">Select Parameters</option>';
                    data.parameters.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.id;
                        opt.textContent = p.parameter;
                        opt.dataset.price = p.price ?? 0;
                        paramSelect.appendChild(opt);
                    });

                    // Packages
                    packageSelect.innerHTML = '<option value="">Select Packages</option>';
                    data.packages.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.id;
                        opt.textContent = p.package_name;
                        opt.dataset.params = JSON.stringify(p.parameters);
                        opt.dataset.price = p.price ?? 0;
                        packageSelect.add(opt);
                    });

                    // Concerns
                    concernsSelect.innerHTML = '<option value="">Select Concern</option>';
                    data.concerns.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.concern;
                        opt.textContent = c.concern;
                        if ("{{ old('concern', $sample->concern ?? '') }}" === c.concern) {
                            opt.selected = true;
                        }
                        concernsSelect.appendChild(opt);
                    });

                    // Preselect package + params in edit mode
                    @if ($sample)
                        if (existingPackage) {
                            packageSelect.value = existingPackage;
                            packageParamIds = JSON.parse(packageSelect.options[packageSelect
                                .selectedIndex].dataset.params || "[]");
                        }
                        renderSelectedParams();
                        recalcAmount();
                    @endif
                } catch (err) {
                    console.error(err);
                }
            });

            // parameter/package logic remains same as before...
        });
    </script>
@endsection
