@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i>Book Tests</h3>
                    </div>
                    <form action="{{ route('user.sample.store') }}" method="POST" enctype="multipart/form-data"
                        id="sampleForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="farmer_id">Farmer</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('fullname', $profile->fullname ?? '') }}" readonly>
                                        <input type="text" name="farmer_id"
                                            value="{{ old('fullname', $profile->id ?? '') }}" hidden>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sample_type">Sample Type</label>
                                        <select id="sample_type" name="sample_type" class="form-control" required>
                                            <option value="">Select Sample Type</option>
                                            @foreach ($sample_type as $type)
                                                <option value="{{ $type->id }}" data-size="{{ $type->sample_size }}">
                                                    {{ $type->e_type }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_id">Field</label>
                                        <select name="field_id" class="form-control" required>
                                            <option value="">Select Field</option>
                                            @foreach ($field as $f)
                                                <option value="{{ $f->id }}">{{ $f->field_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="crop_id">Crop</label>
                                        <select name="crop_id" class="form-control">
                                            <option value="">Select Crop</option>
                                            @foreach ($crop as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="packages">Packages:</label>
                                        <select id="packages" name="packages" class="form-control">
                                            <!-- Options loaded by Fetch -->
                                        </select>
                                        {{-- @foreach ($packages as $package)
                                            <div>
                                                <input type="checkbox" class="package-checkbox" name="packages[]"
                                                    value="{{ $package->id }}">
                                                {{ $package->package_name }}
                                            </div>
                                        @endforeach --}}
                                        {{-- <select name="package_id" class="form-control">
                                            <option value="">No Package</option>
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                            @endforeach --}}
                                    </div>
                                    <div id="selected_params"></div>
                                    <button type="button" id="resetParamsBtn" class="btn btn-info btn-sm mt-2">Reset
                                        Parameters</button>
                                </div>
                                <input type="hidden" id="final_params" name="parameters">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parameters">Select Parameters:</label>
                                        <select id="parameters" name="param" class="form-control">
                                            <!-- Options loaded by Fetch -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Collection Method</label>
                                        <select name="collection_method" class="form-control" required>
                                            <option value="self">Self</option>
                                            <option value="field_agent">Field Agent</option>
                                            <option value="post">Courier/Post</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Quantity of Sample</label>
                                        <input type="text" id="quantity" name="quantity" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="text" id="amount" name="amount" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Concern</label>
                                        <select id="concerns" name="concern" class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{-- <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                                    Submit</button>
                                <a href="{{ route('user.sample') }}" class="btn btn-secondary">Cancel</a> --}}
                                <button type="button" id="addSampleBtn" class="btn btn-primary">Add Sample</button>
                                <button type="button" id="paymentBtn" class="btn btn-success">Proceed to Payment</button>
                            </div>
                        </div>
                    </form>
                    <hr>

                    <h4 id="samplesHeader" style="display:none;">Samples Added</h4>
                    <table id="samplesTable" border="1" style="width:100%; display:none;"
                        class="table datatable table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sample ID</th>
                                <th>Type</th>
                                <th>Parameters</th>
                                <th>Amount</th>
                                <th>concern</th>
                                <th>Quantity of Sample</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- new samples will appear here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    {{-- <td>
        <button type="button" class="editBtn" data-id="${data.sample.id}">Edit</button>
    </td> --}}
    <script>
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
                const res = await fetch("{{ route('user.sample.store') }}", {
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
        document.getElementById('paymentBtn').addEventListener('click', async function() {
            const form = document.getElementById('sampleForm');
            const formData = new FormData(form);

            if (formData.get('sample_type')) {
                await fetch("{{ route('user.sample.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: formData
                });
            }

            window.location.href = "{{ route('user.payments.show', $profile->id) }}";
        });
    </script>
@endsection
