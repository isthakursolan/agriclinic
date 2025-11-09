@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Update Crop Relations</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.crop-varieties') }}">Crop Varieties & Rootstocks</a></li>
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
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-pencil-square me-2"></i>Update Varieties & Rootstocks for {{ $crop->crop }}</h3>
                </div>
                <form action="{{ route('admin.crop-varieties.update', $crop->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div style="padding: 15px;">
                            <div class="row">

                                <!-- Varieties -->
                                <div class="col-md-6">
                                    <h5>Varieties</h5>
                                    <div id="variety-wrapper">
                                        @foreach($crop->varieties as $index => $v)
                                            <div class="input-group mb-2">
                                                <input type="text" name="varieties[{{ $index }}][name]" class="form-control" value="{{ $v->variety }}">
                                                <button type="button" class="btn btn-danger remove-input">X</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-variety" class="btn btn-sm btn-info">+ Add Variety</button>
                                </div>

                                <!-- Rootstocks -->
                                <div class="col-md-6">
                                    <h5>Rootstocks</h5>
                                    <div id="rootstock-wrapper">
                                        @foreach($crop->rootstocks as $index => $r)
                                            <div class="input-group mb-2">
                                                <input type="text" name="rootstocks[{{ $index }}][name]" class="form-control" value="{{ $r->rootstock }}">
                                                <button type="button" class="btn btn-danger remove-input">X</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="add-rootstock" class="btn btn-sm btn-warning">+ Add Rootstock</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div style="padding: 15px;">
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-save me-1"></i> Save
                                </button>
                                <a href="{{ route('admin.crop-varieties') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
document.getElementById('add-variety').addEventListener('click', function(){
    let wrapper = document.getElementById('variety-wrapper');
    let index = wrapper.children.length;
    let newInput = document.createElement('div');
    newInput.classList.add('input-group', 'mb-2');
    newInput.innerHTML = `<input type="text" name="varieties[${index}][name]" class="form-control" placeholder="Enter Variety">
                          <button type="button" class="btn btn-danger remove-input">X</button>`;
    wrapper.appendChild(newInput);
});

document.getElementById('add-rootstock').addEventListener('click', function(){
    let wrapper = document.getElementById('rootstock-wrapper');
    let index = wrapper.children.length;
    let newInput = document.createElement('div');
    newInput.classList.add('input-group', 'mb-2');
    newInput.innerHTML = `<input type="text" name="rootstocks[${index}][name]" class="form-control" placeholder="Enter Rootstock">
                          <button type="button" class="btn btn-danger remove-input">X</button>`;
    wrapper.appendChild(newInput);
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-input')){
        e.target.parentElement.remove();
    }
});
</script>
@endsection
