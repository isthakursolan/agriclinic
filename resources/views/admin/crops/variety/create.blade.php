@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">

            <div class="card card-success">
                <div class="card-header"><h3 class="card-title"><i class="fas fa-plus"></i> Add Varieties</h3></div>

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

                    <div class="card-footer text-right">
                        <button class="btn btn-success">Save Varieties</button>
                        <a href="{{ route('admin.variety') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>

        </div>
    </section>
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
