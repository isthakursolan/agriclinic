@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus"></i> Add Rootstock</h3>
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
                    <form action="{{ route('admin.rootstock.store') }}" method="POST">
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

                            <div id="rootstock-wrapper">
                                <div class="input-group mb-2">
                                    <input type="text" name="rootstocks[]" class="form-control"
                                        placeholder="Enter Rootstock" required>
                                    <button type="button" class="btn btn-danger remove-rootstock">X</button>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary" id="add-rootstock">+ Add Another
                                Rootstock</button>

                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-success">Save Rootstocks</button>
                            <a href="{{ route('admin.rootstock') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>

    <script>
        document.getElementById('add-rootstock').addEventListener('click', function() {
            let wrapper = document.getElementById('rootstock-wrapper');
            let newInput = document.createElement('div');
            newInput.classList.add('input-group', 'mb-2');
            newInput.innerHTML = `
        <input type="text" name="rootstocks[]" class="form-control" placeholder="Enter Rootstock" required>
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
