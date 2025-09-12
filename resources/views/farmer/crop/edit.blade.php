@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class="fas fa-seedling"></i> Update Crop</h3>
                </div>

                <form action="{{ route('user.update.crop', $cropReg->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <!-- Crop Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Crop Name</label>
                                <select name="crop_id" id="crop_id" class="form-control" disabled>
                                    <option value="">Select Crop</option>
                                    @foreach ($crops as $crop)
                                        <option value="{{ $crop->id }}"
                                            data-cat="{{ $crop->category->e_cat ?? '' }}"
                                            {{ $cropReg->name == $crop->crop ? 'selected' : '' }}>
                                            {{ $crop->crop }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Crop Category -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" id="cropCat" class="form-control" readonly
                                    value="{{ $cropReg->crop_cat ?? '' }}">
                            </div>

                            <!-- Variety -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Variety</label>
                                <select id="varietySelect" name="variety" class="form-control" disabled>
                                    <option value="{{ $cropReg->variety }}" selected>{{ $cropReg->variety }}</option>
                                </select>
                            </div>

                            <!-- Rootstock -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rootstock</label>
                                <select id="rootstockSelect" name="rootstock" class="form-control" disabled>
                                    <option value="{{ $cropReg->rootstock }}" selected>{{ $cropReg->rootstock }}</option>
                                </select>
                            </div>

                            <!-- Farmer Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Farmer Name</label>
                                <input type="text" class="form-control" value="{{ $cropReg->farmer->fullname }}" readonly>
                                <input type="hidden" name="farmer_id" value="{{ $cropReg->farmer_id }}">
                            </div>

                            <!-- Plot -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plot Name</label>
                                <select name="plot_id" class="form-control" disabled>
                                    <option value="">Select Plot</option>
                                    @foreach($fields as $field)
                                        <option value="{{ $field->id }}"
                                            {{ $cropReg->plot_id == $field->id ? 'selected' : '' }}>
                                            {{ $field->field_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sowing & Harvest Dates -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sowing Date</label>
                                <input type="date" name="sowing_date" class="form-control"
                                    value="{{ $cropReg->sowing_date }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expected Harvest Date</label>
                                <input type="date" name="expected_harvest_date" class="form-control"
                                    value="{{ $cropReg->expected_harvest_date }}">
                            </div>

                            <!-- Fertilizer Plan -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fertilizer Plan</label>
                                <textarea name="fertilizer_plan" class="form-control">{{ $cropReg->fertilizer_plan }}</textarea>
                            </div>

                            <!-- Description -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control">{{ $cropReg->description }}</textarea>
                            </div>

                            <!-- Photo -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Crop Photo</label>
                                @if($cropReg->photo)
                                    <img src="{{ asset('storage/'.$cropReg->photo) }}" width="100" class="mb-2">
                                @endif
                                <input type="file" name="photo" class="form-control">
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Crop</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    function loadVarietiesAndRootstocks(cropId, selectedVariety = '', selectedRootstock = '') {
        fetch('/user/get-varieties/' + cropId)
            .then(res => res.json())
            .then(data => {
                let varietySelect = document.getElementById('varietySelect');
                varietySelect.innerHTML = '<option value="">--Select Variety--</option>';
                data.forEach(v => {
                    varietySelect.innerHTML += `<option value="${v.variety}" ${v.variety===selectedVariety?'selected':''}>${v.variety}</option>`;
                });
            });

        fetch('/user/get-rootstocks/' + cropId)
            .then(res => res.json())
            .then(data => {
                let rootstockSelect = document.getElementById('rootstockSelect');
                rootstockSelect.innerHTML = '<option value="">--Select Rootstock--</option>';
                data.forEach(r => {
                    rootstockSelect.innerHTML += `<option value="${r.rootstock}" ${r.rootstock===selectedRootstock?'selected':''}>${r.rootstock}</option>`;
                });
            });
    }

    document.getElementById('crop_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let cropId = selected.value;
        let cropCat = selected.getAttribute('data-cat');
        document.getElementById('cropCat').value = cropCat;
        loadVarietiesAndRootstocks(cropId);
    });

    // Load initial values
    window.addEventListener('load', function() {
        let cropId = document.getElementById('crop_id').value;
        let selectedVariety = "{{ $cropReg->variety }}";
        let selectedRootstock = "{{ $cropReg->rootstock }}";
        loadVarietiesAndRootstocks(cropId, selectedVariety, selectedRootstock);
    });
</script>
@endsection
