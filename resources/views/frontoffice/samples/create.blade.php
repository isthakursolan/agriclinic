@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-vial"></i> Register Samples</h3>
                </div>
                <form action="{{ route('frontoffice.samples.store') }}" method="POST" enctype="multipart/form-data" id="sampleForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="farmer_id">Farmer <span class="text-danger">*</span></label>
                                    <select name="farmer_id" id="farmer_id" class="form-control" required>
                                        <option value="">-- Select a Farmer --</option>
                                        @foreach ($farmers as $farmer)
                                            <option value="{{ $farmer->id }}" data-fields="{{ json_encode($farmer->fields) }}" data-crops="{{ json_encode($farmer->activeCrops) }}">{{ $farmer->profile->fullname ?? $farmer->name }} ({{ $farmer->contact }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sample_type_id">Sample Type <span class="text-danger">*</span></label>
                                    <select id="sample_type_id" name="sample_type_id" class="form-control" required>
                                        <option value="">-- Select Sample Type --</option>
                                        @foreach ($sampleTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->e_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field_id">Field</label>
                                    <select name="field_id" id="field_id" class="form-control">
                                        <option value="">-- Select Field (Optional) --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="crop_id">Crop</label>
                                    <select name="crop_id" id="crop_id" class="form-control">
                                        <option value="">-- Select Crop (Optional) --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packages">Packages:</label>
                                    <select id="packages" name="packages[]" class="form-control" multiple></select>
                                </div>
                                <div id="selected_params_display" class="mb-2"></div>
                                <input type="hidden" id="final_params" name="parameters">
                                <div>
                                    <button type="button" id="resetParamsBtn" class="btn btn-sm btn-secondary" style="display:none;">Reset Selections</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parameters">Individual Parameters:</label>
                                    <select id="parameters" name="param" class="form-control" multiple></select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple.</small>
                                </div>
                            </div>
                             <div class="col-md-8">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" id="remarks" class="form-control" rows="2" placeholder="Any additional notes..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">Total Amount (₹)</label>
                                    <input type="number" name="amount" id="amount" class="form-control" readonly required>
                                    <h4 id="totalAmountDisplay" class="font-weight-bold text-center mt-2">Total: ₹0.00</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right bg-white">
                            <button type="button" id="addSampleBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Add Sample to List</button>
                            <button type="button" id="paymentBtn" class="btn btn-success" disabled><i class="fas fa-credit-card"></i> Proceed to Payment</button>
                        </div>
                    </div>
                </form>
                <hr>

                <div id="samplesListCard" class="card mt-4" style="display:none;">
                    <div class="card-header">
                        <h4 class="card-title">Samples Added for Payment</h4>
                    </div>
                    <div class="card-body">
                        <table id="samplesTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sample ID</th>
                                    <th>Farmer</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- new samples will appear here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const farmerSelect = document.getElementById('farmer_id');
    const fieldSelect = document.getElementById('field_id');
    const cropSelect = document.getElementById('crop_id');
    const packagesSelect = document.getElementById('packages');
    const parametersSelect = document.getElementById('parameters');
    const amountInput = document.getElementById('amount');
    const totalDisplay = document.getElementById('totalAmountDisplay');
    const addSampleBtn = document.getElementById('addSampleBtn');
    const paymentBtn = document.getElementById('paymentBtn');
    const sampleForm = document.getElementById('sampleForm');
    const samplesListCard = document.getElementById('samplesListCard');
    const samplesTableBody = document.querySelector('#samplesTable tbody');
    let addedSamples = [];
    let allParameters = [];
    let allPackages = [];
    let selectedParamIds = [];
    const selectedParamsDiv = document.getElementById('selected_params_display');
    const finalParamsInput = document.getElementById('final_params');
    const resetBtn = document.getElementById('resetParamsBtn');

    // Populate Field and Crop dropdowns based on Farmer selection
    farmerSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const fields = JSON.parse(selectedOption.dataset.fields || '[]');
        const crops = JSON.parse(selectedOption.dataset.crops || '[]');

        // Populate fields
        fieldSelect.innerHTML = '<option value="">-- Select Field (Optional) --</option>';
        fields.forEach(field => {
            fieldSelect.innerHTML += `<option value="${field.id}">${field.field_name}</option>`;
        });

        // Populate crops
        cropSelect.innerHTML = '<option value="">-- Select Crop (Optional) --</option>';
        crops.forEach(crop => {
            cropSelect.innerHTML += `<option value="${crop.id}">${crop.name}</option>`;
        });
    });

    document.getElementById('sample_type_id').addEventListener('change', async function() {
        const sampleTypeId = this.value;
        resetSelections();
        if (!sampleTypeId) return;

        try {
            const res = await fetch(`/frontoffice/samples/sample-type/${sampleTypeId}/data`);
            const data = await res.json();
            allParameters = data.parameters || [];
            allPackages = data.packages || [];
            populateTestDropdowns();
        } catch (err) {
            console.error('Error fetching sample type data:', err);
        }
    });

    function populateTestDropdowns() {
        parametersSelect.innerHTML = '';
        allParameters.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = `${p.parameter} (₹${p.price || 0})`;
            opt.dataset.price = p.price || 0;
            opt.dataset.name = p.parameter;
            parametersSelect.appendChild(opt);
        });

        packagesSelect.innerHTML = '';
        allPackages.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = `${p.name} (₹${p.amount || 0})`;
            opt.dataset.price = p.amount || 0;
            opt.dataset.name = p.name;
            opt.dataset.params = JSON.stringify(p.parameters || []);
            packagesSelect.appendChild(opt);
        });
    }

    function renderSelectedParams() {
        selectedParamsDiv.innerHTML = '';
        resetBtn.style.display = selectedParamIds.length > 0 ? 'inline-block' : 'none';

        selectedParamIds.forEach(id => {
            const param = allParameters.find(p => p.id == id);
            if (!param) return;

            const span = document.createElement('span');
            span.className = 'badge badge-pill badge-info mr-1 mb-1';
            span.textContent = param.parameter;
            selectedParamsDiv.appendChild(span);
        });

        finalParamsInput.value = JSON.stringify(selectedParamIds);
    }

    function calculateTotal() {
        const selectedPackages = Array.from(packagesSelect.selectedOptions).map(opt => opt.value);
        const selectedParameters = Array.from(parametersSelect.selectedOptions).map(opt => opt.value);

        let packageParamIds = [];
        selectedPackages.forEach(pkgId => {
            const pkg = allPackages.find(p => p.id == pkgId);
            if (pkg) packageParamIds.push(...pkg.parameters);
        });

        selectedParamIds = Array.from(new Set([...packageParamIds, ...selectedParameters.map(id => parseInt(id))]));
        renderSelectedParams();

        // Hide button if no farmer is selected
        addSampleBtn.disabled = !farmerSelect.value;

        fetch('{{ route("frontoffice.samples.getPrices") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                packages: selectedPackages, // Send package IDs
                parameters: selectedParameters // Send individual param IDs
            })
        })
        .then(response => response.json())
        .then(data => {
            const total = parseFloat(data.total).toFixed(2);
            amountInput.value = total;
            totalDisplay.textContent = 'Total: ₹' + total;
        })
        .catch(error => console.error('Error calculating total:', error));
    }

    packagesSelect.addEventListener('change', calculateTotal);
    parametersSelect.addEventListener('change', calculateTotal);
    resetBtn.addEventListener('click', resetSelections);

    function resetSelections() {
        packagesSelect.innerHTML = '';
        parametersSelect.innerHTML = '';
        selectedParamIds = [];
        renderSelectedParams();
        calculateTotal();
    }

    addSampleBtn.addEventListener('click', async function() {
        const formData = new FormData(sampleForm);
        // Use the consolidated list of parameter IDs
        formData.set('parameters', finalParamsInput.value);
        // Add selected package IDs
        const selectedPackages = Array.from(packagesSelect.selectedOptions).map(opt => opt.value);
        formData.delete('packages[]'); // clear existing before appending
        selectedPackages.forEach(p => formData.append('packages[]', p));

        // Basic validation
        if (!formData.get('farmer_id') || !formData.get('sample_type_id') || parseFloat(formData.get('amount')) <= 0) {
            alert('Please select a Farmer, Sample Type, and at least one test.');
            return;
        }

        try {
            const res = await fetch("{{ route('frontoffice.samples.store') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            });
            const data = await res.json();

            if (data.success) {
                addedSamples.push(data.sample);
                renderSamplesTable();
                sampleForm.reset();
                // Reset dropdowns related to the farmer
                fieldSelect.innerHTML = '<option value="">-- Select Field (Optional) --</option>';
                cropSelect.innerHTML = '<option value="">-- Select Crop (Optional) --</option>';
                amountInput.value = '';
                totalDisplay.textContent = 'Total: ₹0.00';
            } else {
                alert("Error: " + (data.message || "Could not add sample."));
            }
        } catch (err) {
            console.error(err);
            alert("A network error occurred. Please try again.");
        }
    });

    function renderSamplesTable() {
        samplesTableBody.innerHTML = '';
        if (addedSamples.length > 0) {
            samplesListCard.style.display = 'block';
            paymentBtn.disabled = false;
        } else {
            samplesListCard.style.display = 'none';
            paymentBtn.disabled = true;
        }

        addedSamples.forEach((sample, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${sample.sample_id}</td>
                <td>${farmerSelect.options[farmerSelect.selectedIndex].text}</td>
                <td>${document.querySelector(`#sample_type_id option[value='${sample.sample_type_id}']`).textContent}</td>
                <td>${parseFloat(sample.amount).toFixed(2)}</td>
                <td><button type="button" class="btn btn-sm btn-danger remove-sample" data-index="${index}">Remove</button></td>
            `;
            samplesTableBody.appendChild(row);
        });
    }

    samplesTableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-sample')) {
            const index = e.target.dataset.index;
            addedSamples.splice(index, 1); // This is a temporary removal. A server-side delete would be better.
            renderSamplesTable();
        }
    });

    paymentBtn.addEventListener('click', function() {
        const farmerId = farmerSelect.value;
        if (farmerId && addedSamples.length > 0) {
            window.location.href = `/frontoffice/samples/payment/${farmerId}`;
        } else {
            alert('Please add at least one sample for the selected farmer.');
        }
    });
});
</script>
@endpush
