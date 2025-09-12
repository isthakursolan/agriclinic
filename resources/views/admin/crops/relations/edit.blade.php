@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Update Varieties & Rootstocks for {{ $crop->crop }}</h3>
                </div>
                <form action="{{ route('admin.crops.update', $crop->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
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
