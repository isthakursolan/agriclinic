@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-flower1 me-2"></i> Add New Crop</h3>
                    </div>
                    <form action="{{ route('user.crop.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Crop Name</label>
                                        {{-- <input type="text" name="name" class="form-control" required> --}}
                                        <select class="form-control" name="name" id="crop_id" required>
                                            <option value="">Select Crop</option>
                                            @foreach ($crops as $crop)
                                                <option value="{{ $crop->crop }}" data-cat="{{ $crop->cat }}"
                                                    data-type="{{ $crop->type }}" data-id="{{ $crop->id }}">
                                                    {{ $crop->crop }}</option>
                                            @endforeach
                                            {{-- <option value="add_new">+ Add New Crop</option> --}}
                                        </select>
                                        {{-- <input type="text" id="new_crop" name="new_crop"
                                            class="form-control mt-2 d-none" placeholder="Enter New Crop"> --}}
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Type of Crop</label>
                                        <input type="text" name="type_of_crop" id="cropType" class="form-control"
                                            readonly>
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <input type="text" name="crop_cat" id="cropCat" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Variety</label>
                                        {{-- <input type="text" name="variety" class="form-control"> --}}
                                        <select id="varietySelect" name="variety" class="form-control">
                                        </select>
                                        <input type="text" id="new_variety" name="new_variety"
                                            class="form-control mt-2 d-none" placeholder="Enter New Variety">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Rootstock</label>
                                        {{-- <input type="text" name="rootstock" class="form-control"> --}}
                                        <select id="rootstockSelect" name="rootstock" class="form-control">
                                        </select>
                                        <input type="text" id="new_rootstock" name="new_rootstock"
                                            class="form-control mt-2 d-none" placeholder="Enter New Rootstock">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Farmer Name</label>
                                        {{-- <input type="text" name="farmer_id" class="form-control" required> --}}
                                        <input type="text" class="form-control"
                                            value="{{ old('fullname', $farmer->fullname ?? '') }}" readonly>
                                        <input type="text" name="farmer_id"
                                            value="{{ old('fullname', $farmer->id ?? '') }}" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Plot Name</label>
                                        {{-- <input type="text" name="plot_id" class="form-control" required> --}}
                                        <select class="form-control" name="plot_id" required>
                                            <option value="">Select Field</option>
                                            @foreach ($fields as $field)
                                                <option value="{{ $field->id }}">{{ $field->field_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sowing Date</label>
                                        <input type="date" name="sowing_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Expected Harvest Date</label>
                                        <input type="date" name="expected_harvest_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Fertilizer Plan</label>
                                        <textarea name="fertilizer_plan" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Crop Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i>
                                    Submit</button>
                                <a href="{{ route('user.crop') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.getElementById('crop_id').addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];
            let cropType = selected.getAttribute('data-type');
            let cropCat = selected.getAttribute('data-cat');
            let cropId = selected.getAttribute('data-id');

            // Set crop type
            fetch('/user/get-croptype/' + cropType)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cropType').value = data;
                });
            fetch('/user/get-cropcat/' + cropCat)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cropCat').value = data;
                });

            // Fetch varieties
            fetch('/user/get-varieties/' + cropId)
                .then(res => res.json())
                .then(data => {
                    let varietySelect = document.getElementById('varietySelect');
                    varietySelect.innerHTML = '';
                    if (data.length === 0) {
                        varietySelect.innerHTML = '<option value="">No varieties available</option>';
                    } else {
                        varietySelect.innerHTML = '<option value="">--Select Variety--</option>';
                        data.forEach(v => {
                            varietySelect.innerHTML +=
                                `<option value="${v.variety}">${v.variety}</option>`;
                        });
                    }
                });

            // Fetch rootstocks
            fetch('/user/get-rootstocks/' + cropId)
                .then(res => res.json())
                .then(data => {
                    let rootstockSelect = document.getElementById('rootstockSelect');
                    rootstockSelect.innerHTML = '';
                    if (data.length === 0) {
                        rootstockSelect.innerHTML = '<option value="">No rootstocks available</option>';
                    } else {
                        rootstockSelect.innerHTML = '<option value="">--Select Rootstock--</option>';
                        data.forEach(r => {
                            rootstockSelect.innerHTML +=
                                `<option value="${r.rootstock}">${r.rootstock}</option>`;
                        });
                    }
                });
        });
    </script>
@endsection
