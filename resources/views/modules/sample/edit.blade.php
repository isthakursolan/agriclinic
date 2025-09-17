@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Sample {{ $sample->sample_id }}</h3>
            </div>
            <form action="{{ route('sample.update', $sample->id) }}" method="POST" id="sampleForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Sample Type -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sample_type_id">Sample Type</label>
                                <select name="sample_type_id" id="sample_type_id" class="form-control" required>
                                    @foreach ($sampleTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $sample->sample_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->e_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Parameters -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parameters">Parameters</label>
                                <select name="parameters[]" id="parameters" class="form-control" multiple>
                                    @php
                                        $selectedParams = json_decode($sample->parameters) ?? [];
                                    @endphp
                                    @foreach ($parameters as $p)
                                        <option value="{{ $p->id }}"
                                            {{ in_array($p->id, $selectedParams) ? 'selected' : '' }}>
                                            {{ $p->parameter }} (₹{{ $p->price }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Packages -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="packages">Packages</label>
                                <select name="packages[]" id="packages" class="form-control" multiple>
                                    @php
                                        $selectedPackages = json_decode($sample->packages) ?? [];
                                    @endphp
                                    @foreach ($packages as $pkg)
                                        <option value="{{ $pkg['id'] }}"
                                            {{ in_array($pkg['id'], $selectedPackages) ? 'selected' : '' }}>
                                            {{ $pkg['package_name'] }} (₹{{ $pkg['price'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Concerns -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="concern">Concern</label>
                                <select name="concern" id="concern" class="form-control">
                                    <option value="" selected disabled>Select Concern</option>
                                    @foreach ($concerns as $c)
                                        <option value="{{ $c->concern }}"
                                            {{ $sample->concern == $c->concern ? 'selected' : '' }}>
                                            {{ $c->concern }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Read-only fields -->
                        <div class="col-md-6">
                            <label>Farmer</label>
                            <input type="text" value="{{ $sample->farmer->profile->fullname }}" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label>Field</label>
                            <input type="text" value="{{ $sample->field->field_name }}" class="form-control" disabled>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <a href="{{ route('samples.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
  <script>
        document.addEventListener('DOMContentLoaded', () => {
            const farmerSelect = document.getElementById('farmer_id');
            const fieldSelect = document.getElementById('field_id');
            const cropSelect = document.getElementById('crop_id');

            let selectedFarmerId = ""; // Global variable to store selected farmer ID

            farmerSelect.addEventListener('change', () => {
                const selectedOption = farmerSelect.selectedOptions[0];

                // Clear dropdowns
                fieldSelect.innerHTML = '<option value="">-- Select Field --</option>';
                cropSelect.innerHTML = '<option value="">-- Select Crop --</option>';

                try {
                    // Parse data from selected option
                    const fields = JSON.parse(selectedOption.dataset.fields || '[]');
                    const crops = JSON.parse(selectedOption.dataset.crops || '[]');

                    selectedFarmerId = farmerSelect.value; // Store current farmer id globally

                    // Populate fields
                    fields.forEach(field => {
                        const option = document.createElement('option');
                        option.value = field.id;
                        option.textContent = field.field_name;
                        fieldSelect.appendChild(option);
                    });

                    // Populate crops
                    crops.forEach(crop => {
                        const option = document.createElement('option');
                        option.value = crop.id;
                        option.textContent = crop.name;
                        cropSelect.appendChild(option);
                    });

                    // Trigger change for any listeners if needed (like paymentBtn)
                    fieldSelect.dispatchEvent(new Event('change'));
                    cropSelect.dispatchEvent(new Event('change'));

                } catch (e) {
                    console.error("Invalid data format in options:", e);
                }
            });

            // Optional: Re-use selectedFarmerId in any other JS code like AJAX calls
            document.getElementById('addSampleBtn').addEventListener('click', () => {
                console.log("Farmer ID to store:", selectedFarmerId); // You can now send it to backend
            });

            // Rest of your JS code here...
        });
        document.addEventListener('DOMContentLoaded', () => {
            const sampleTypeSelect = document.getElementById('sample_type_id');

            if (sampleTypeSelect.value) {
                loadSampleData(sampleTypeSelect.value);
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            const sampleTypeSelect = document.getElementById('sample_type');
            const paramSelect = document.getElementById('parameters');
            const packageSelect = document.getElementById('packages');
            const selectedParamsDiv = document.getElementById('selected_params');
            const finalParamsInput = document.getElementById('final_params');
            const amountInput = document.getElementById('amount');
            const quantityInput = document.getElementById('quantity');

            let selectedParamIds = [];
            let packageParamIds = [];

            sampleTypeSelect.addEventListener('change', async function() {
                const sampleTypeId = this.value;
                const size = this.options[this.selectedIndex].dataset.size || '';
                quantityInput.value = size;

                if (!sampleTypeId) return;

                try {
                    const res = await fetch(`/user/sample-type/${sampleTypeId}/data`);
                    const data = await res.json();

                    // ---------------- Parameters ----------------
                    paramSelect.innerHTML = '<option value="">Select Parameters</option>';
                    data.parameters.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.id;
                        opt.textContent = p.parameter;
                        opt.dataset.price = p.price ?? 0;
                        paramSelect.appendChild(opt);
                    });

                    // ---------------- Packages ----------------
                    packageSelect.innerHTML = '<option value="">Select Packages</option>';
                    data.packages.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.id;
                        opt.textContent = p.package_name;
                        opt.dataset.params = JSON.stringify(p.parameters);
                        opt.dataset.price = p.price ?? 0;
                        packageSelect.add(opt);
                    });

                    // ---------------- Concerns ----------------
                    const concernsSelect = document.getElementById('concerns');
                    concernsSelect.innerHTML = '<option value="">Select Concern</option>';
                    data.concerns.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.concern;
                        opt.textContent = c.concern;
                        concernsSelect.appendChild(opt);
                    });

                    // ---------------- Package Selection ----------------
                    packageSelect.addEventListener('change', () => {
                        const selectedOpt = packageSelect.options[packageSelect.selectedIndex];
                        if (!selectedOpt.value) return;

                        // Parse package parameters
                        packageParamIds = JSON.parse(selectedOpt.dataset.params || "[]");

                        // Merge package + extra manual params
                        selectedParamIds = Array.from(new Set([...packageParamIds, ...
                            selectedParamIds.filter(id => !packageParamIds.includes(
                                id))
                        ]));

                        // Hide package parameters from manual dropdown
                        [...paramSelect.options].forEach(opt => {
                            if (packageParamIds.includes(+opt.value)) opt.hidden = true;
                            else opt.hidden = false;
                        });

                        renderSelectedParams();
                        recalcAmount();
                    });

                    // ---------------- Manual Parameter Selection ----------------
                    paramSelect.addEventListener('change', () => {
                        const id = +paramSelect.value;
                        if (!id || selectedParamIds.includes(id)) return;

                        selectedParamIds.push(id);
                        renderSelectedParams();

                        // Hide from dropdown
                        const opt = [...paramSelect.options].find(o => +o.value === id);
                        if (opt) opt.hidden = true;

                        paramSelect.value = "";
                        recalcAmount();
                    });

                    // ---------------- Render Selected Parameters ----------------
                    function renderSelectedParams() {
                        selectedParamsDiv.innerHTML = "";
                        selectedParamIds.forEach(id => {
                            const opt = [...paramSelect.options].find(o => +o.value === id);
                            if (!opt) return;

                            const span = document.createElement('span');
                            span.textContent = opt.textContent;
                            span.style.margin = '0 5px';
                            span.style.padding = '3px 6px';
                            span.style.background = packageParamIds.includes(id) ? '#d1ffd1' :
                                '#d1e0ff';
                            span.style.borderRadius = '6px';

                            const cancel = document.createElement('span');
                            cancel.textContent = ' ❌';
                            cancel.style.cursor = 'pointer';
                            cancel.style.color = 'red';
                            cancel.onclick = () => {
                                if (packageParamIds.includes(id)) {
                                    // ALERT before removing package
                                    if (confirm(
                                            "This parameter belongs to a package. Removing it will cancel the package. Continue?"
                                        )) {
                                        // Remove package params
                                        selectedParamIds = selectedParamIds.filter(pid => !
                                            packageParamIds.includes(pid));
                                        packageSelect.value = "";
                                        packageParamIds = [];

                                        // Unhide all parameters
                                        [...paramSelect.options].forEach(o => o.hidden =
                                            false);

                                        renderSelectedParams();
                                        recalcAmount();
                                    }
                                } else {
                                    // Remove extra param
                                    selectedParamIds = selectedParamIds.filter(pid =>
                                        pid !== id);
                                    const opt = [...paramSelect.options].find(o => +o
                                        .value === id);
                                    if (opt) opt.hidden = false;

                                    renderSelectedParams();
                                    recalcAmount();
                                }
                            };

                            span.appendChild(cancel);
                            selectedParamsDiv.appendChild(span);
                        });

                        // Sync with hidden input
                        finalParamsInput.value = JSON.stringify(selectedParamIds);
                    }

                    // ---------------- Recalculate Amount ----------------
                    function recalcAmount() {
                        let total = 0;

                        // Package price
                        if (packageSelect.value) {
                            total += parseFloat(packageSelect.options[packageSelect.selectedIndex]
                                .dataset.price || 0);
                        }

                        // Extra manual parameters price
                        selectedParamIds.forEach(id => {
                            if (!packageParamIds.includes(id)) {
                                const opt = [...paramSelect.options].find(o => +o.value === id);
                                total += parseFloat(opt?.dataset.price || 0);
                            }
                        });

                        amountInput.value = total;
                    }
                    // ---------------- Reset Parameters ----------------
                    document.getElementById('resetParamsBtn').addEventListener('click', () => {
                        selectedParamIds = [];
                        packageParamIds = [];
                        packageSelect.value = "";

                        // Unhide all parameter options
                        [...paramSelect.options].forEach(opt => opt.hidden = false);

                        // Clear selected params div + hidden input
                        selectedParamsDiv.innerHTML = "";
                        finalParamsInput.value = "[]";

                        // Reset amount
                        amountInput.value = 0;
                    });


                } catch (err) {
                    console.error(err);
                }
            });
        });
        document.getElementById('addSampleBtn').addEventListener('click', async function() {
            const form = document.getElementById('sampleForm');
            const formData = new FormData(form);

            try {
                const res = await fetch("{{ route('sample.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                });

                const data = await res.json();

                if (data.success) {
                    // Show table if hidden
                    document.getElementById('samplesHeader').style.display = 'block';
                    document.getElementById('samplesTable').style.display = 'table';

                    // Append new row
                    const tbody = document.querySelector('#samplesTable tbody');
                    const row = document.createElement('tr');
                    row.setAttribute("data-id", data.sample.id);
                    row.innerHTML = `
                <td>${data.sample.sample_id}</td>
                <td>${data.sample.sample_type}</td>
                <td>${data.sample.parameters.join(', ')}</td>
                <td>${data.sample.amount}</td>
                <td>${data.sample.concern}</td>
                <td>${data.sample.quantity}</td>

            `;
                    tbody.appendChild(row);

                    form.reset();
                } else {
                    alert("Error: " + data.message);
                }
            } catch (err) {
                console.error(err);
                alert("Something went wrong!");
            }
        });

        // Edit Sample
        document.addEventListener("click", async function(e) {
            if (e.target.classList.contains("editBtn")) {
                const sampleId = e.target.dataset.id;

                try {
                    const res = await fetch(`/user/samples/${sampleId}/edit`); // you need a route for this
                    const data = await res.json();

                    if (data.success) {
                        // Fill form with existing sample values
                        document.querySelector("[name='sample_type']").value = data.sample.sample_type;
                        document.querySelector("[name='amount']").value = data.sample.amount;
                        // if parameters are multiple:
                        if (Array.isArray(data.sample.parameters)) {
                            // handle your parameter inputs accordingly
                        }

                        // Remove old row from table (farmer will re-save after editing)
                        const row = document.querySelector(`#samplesTable tr[data-id="${sampleId}"]`);
                        if (row) row.remove();
                    } else {
                        alert("Could not fetch sample details.");
                    }
                } catch (err) {
                    console.error(err);
                    alert("Error loading sample.");
                }
            }
        });

        // Proceed to Payment
        document.getElementById('paymentBtn').addEventListener('click', async function () {
            const form = document.getElementById('sampleForm');
            const formData = new FormData(form);
            const farmerId = formData.get('farmer_id');

            // ❗ Prevent redirect if farmer and sample type not selected
            if (!formData.get('sample_type') || !farmerId) {
                alert("Please select a farmer and sample type before proceeding.");
                return;
            }

            try {
                await fetch("{{ route('sample.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                });
            } catch (err) {
                console.error("Error storing sample data:", err);
                alert("Failed to save samples. Try again.");
                return;
            }

            // ✅ Redirect to payment with farmer_id in URL
            window.location.href = "{{ route('payments.show') }}?farmer_id=" + encodeURIComponent(farmerId);
        });

        async function loadSampleData(sampleTypeId) {
            const paramSelect = document.getElementById('parameters');
            const packageSelect = document.getElementById('packages');
            const concernsSelect = document.getElementById('concern');

            try {
                const res = await fetch(`/user/sample-type/${sampleTypeId}/data`);
                const data = await res.json();

                // Clear and re-populate dropdowns
                paramSelect.innerHTML = '<option value="">-- Select Parameters --</option>';
                packageSelect.innerHTML = '<option value="">-- Select Packages --</option>';
                concernsSelect.innerHTML = '<option value="">-- Select Concern --</option>';

                // Parameters
                data.parameters.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = `${p.parameter} (₹${p.price})`;

                    // Set as selected if already in sample
                    if (Array.isArray($selectedParams) && $selectedParams.includes(p.id)) {
                        opt.selected = true;
                    }

                    paramSelect.appendChild(opt);
                });

                // Packages
                data.packages.forEach(pkg => {
                    const opt = document.createElement('option');
                    opt.value = pkg.id;
                    opt.textContent = `${pkg.name} (₹${pkg.price})`;

                    if (Array.isArray($selectedPackages) && $selectedPackages.includes(pkg.id)) {
                        opt.selected = true;
                    }

                    packageSelect.appendChild(opt);
                });

                // Concerns
                data.concerns.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.concern;
                    opt.textContent = c.concern;

                    if (c.concern === '{{ $sample->concern }}') {
                        opt.selected = true;
                    }

                    concernsSelect.appendChild(opt);
                });

            } catch (err) {
                console.error("Failed to load sample type data:", err);
            }
        }
    </script>
@endsection
