@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">

                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Update Varieties for {{ $crop->crop }}</h3>
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
                    <form action="{{ route('admin.variety.update', $crop->id) }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div id="variety-wrapper">
                                @foreach ($crop->varieties as $variety)
                                    <div class="input-group mb-2">
                                        <input type="hidden" name="varieties[{{ $loop->index }}][id]"
                                            value="{{ $variety->id }}">
                                        <input type="text" name="varieties[{{ $loop->index }}][name]"
                                            class="form-control" value="{{ $variety->variety }}" placeholder="Enter Variety"
                                            required>
                                        <button type="button" class="btn btn-danger remove-variety">X</button>
                                    </div>
                                @endforeach
                            </div>


                            {{-- <button type="button" class="btn btn-secondary" id="add-variety">+ Add Another Variety</button> --}}
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-warning">Update Varieties</button>
                            <a href="{{ route('admin.variety') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('add-variety').addEventListener('click', function() {
            let wrapper = document.getElementById('variety-wrapper');
            let index = wrapper.children.length;
            let newInput = document.createElement('div');
            newInput.classList.add('input-group', 'mb-2');
            newInput.innerHTML = `
        <input type="text" name="varieties[${index}][name]" class="form-control" placeholder="Enter Variety" required>
        <button type="button" class="btn btn-danger remove-variety">X</button>
    `;
            wrapper.appendChild(newInput);
        });

        // Remove variety field dynamically
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variety')) {
                e.target.parentElement.remove();
            }
        });
    </script>
@endsection
