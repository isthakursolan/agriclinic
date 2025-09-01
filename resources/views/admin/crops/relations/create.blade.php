@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Add Crop Relations</h3>
                </div>
                <form action="{{ route('admin.crops.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Select Crop</label>
                            <select name="crop_id" class="form-control" required>
                                <option value="">-- Select Crop --</option>
                                @foreach($crops as $crop)
                                    <option value="{{ $crop->id }}">{{ $crop->crop }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <!-- Varieties -->
                            <div class="col-md-6">
                                <h5>Varieties</h5>
                                <div id="variety-wrapper"></div>
                                <button type="button" id="add-variety" class="btn btn-sm btn-info">+ Add Variety</button>
                            </div>

                            <!-- Rootstocks -->
                            <div class="col-md-6">
                                <h5>Rootstocks</h5>
                                <div id="rootstock-wrapper"></div>
                                <button type="button" id="add-rootstock" class="btn btn-sm btn-warning">+ Add Rootstock</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('admin.crops') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
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
