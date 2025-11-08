@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Add Crop Relations</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.crop-varieties') }}">Crop Varieties & Rootstocks</a></li>
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
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-link-45deg me-2"></i>Add Crop Relations</h3>
                </div>
                <form action="{{ route('admin.crop-varieties.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div style="padding: 15px;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Select Crop <span style="color: #777777;">*</span></label>
                                <select name="crop_id" class="form-select" required>
                                    <option value="">-- Select Crop --</option>
                                    @foreach($crops as $crop)
                                        <option value="{{ $crop->id }}">{{ $crop->crop }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <!-- Varieties -->
                                <div class="col-md-6">
                                    <h5 class="mb-3 fw-bold" style="color: #777777;">Varieties</h5>
                                    <div id="variety-wrapper"></div>
                                    <button type="button" id="add-variety" class="btn btn-sm btn-info">+ Add Variety</button>
                                </div>

                                <!-- Rootstocks -->
                                <div class="col-md-6">
                                    <h5 class="mb-3 fw-bold" style="color: #777777;">Rootstocks</h5>
                                    <div id="rootstock-wrapper"></div>
                                    <button type="button" id="add-rootstock" class="btn btn-sm btn-warning">+ Add Rootstock</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-save me-1"></i> Save
                            </button>
                            <a href="{{ route('admin.crop-varieties') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
function addInput(wrapperId, name){
    let wrapper = document.getElementById(wrapperId);
    let index = wrapper.children.length;
    let newInput = document.createElement('div');
    newInput.classList.add('input-group','mb-2');
    newInput.innerHTML = `<input type="text" name="${name}[${index}][name]" class="form-control" placeholder="Enter name">
                          <button type="button" class="btn btn-danger remove-input">X</button>`;
    wrapper.appendChild(newInput);
}

document.getElementById('add-variety').addEventListener('click', function(){
    addInput('variety-wrapper', 'varieties');
});
document.getElementById('add-rootstock').addEventListener('click', function(){
    addInput('rootstock-wrapper', 'rootstocks');
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-input')){
        e.target.parentElement.remove();
    }
});
</script>
@endsection
