@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Update Rootstock</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.rootstock') }}">Rootstocks</a></li>
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
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-pencil-square me-2"></i> Update Rootstock for {{ $crop->crop }}</h3>
                </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.rootstock.update', $crop->id) }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div id="rootstock-wrapper">
                                @foreach ($crop->rootstocks as $index => $root)
                                    <div class="input-group mb-2">
                                        <input type="hidden" name="rootstocks[{{ $index }}][id]"
                                            value="{{ $root->id }}">
                                        <input type="text" name="rootstocks[{{ $index }}][name]"
                                            class="form-control" value="{{ $root->rootstock }}"
                                            placeholder="Enter Rootstock" required>
                                        <button type="button" class="btn btn-danger remove-rootstock">X</button>
                                    </div>
                                @endforeach
                            </div>


                            {{-- <button type="button" class="btn btn-secondary" id="add-rootstock">+ Add Another Rootstock</button> --}}
                        </div>

                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-save me-1"></i> Update Rootstock
                                </button>
                                <a href="{{ route('admin.rootstock') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-rootstock').addEventListener('click', function() {
            let wrapper = document.getElementById('rootstock-wrapper');
            let index = wrapper.children.length;
            let newInput = document.createElement('div');
            newInput.classList.add('input-group', 'mb-2');
            newInput.innerHTML = `
        <input type="text" name="rootstocks[${index}][name]" class="form-control" placeholder="Enter Rootstock" required>
        <button type="button" class="btn btn-danger remove-rootstock">X</button>
    `;
            wrapper.appendChild(newInput);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-rootstock')) {
                e.target.parentElement.remove();
            }
        });
    </script>
@endsection
