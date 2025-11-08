@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Add Varieties</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.variety') }}">Varieties</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;"><h3 class="card-title mb-0 text-white"><i class="bi bi-plus-circle me-2"></i> Add Varieties</h3></div>

                 @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <form action="{{ route('admin.variety.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="crop">Select Crop</label>
                            <select name="crop" id="crop" class="form-control" required>
                                <option value="">-- Select Crop --</option>
                                @foreach ($crops as $crop)
                                    <option value="{{ $crop->id }}">{{ $crop->crop }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="variety-wrapper">
                            <div class="input-group mb-2">
                                <input type="text" name="varieties[]" class="form-control" placeholder="Enter Variety" required>
                                <button type="button" class="btn btn-danger remove-variety">X</button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" id="add-variety">+ Add Another Variety</button>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-start gap-2">
                            <button type="submit" class="btn btn-dark">
                                <i class="bi bi-save me-1"></i> Save Varieties
                            </button>
                            <a href="{{ route('admin.variety') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
document.getElementById('add-variety').addEventListener('click', function () {
    let wrapper = document.getElementById('variety-wrapper');
    let newInput = document.createElement('div');
    newInput.classList.add('input-group', 'mb-2');
    newInput.innerHTML = `
        <input type="text" name="varieties[]" class="form-control" placeholder="Enter Variety" required>
        <button type="button" class="btn btn-danger remove-variety">X</button>
    `;
    wrapper.appendChild(newInput);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-variety')) {
        e.target.parentElement.remove();
    }
});
</script>
@endsection
