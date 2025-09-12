@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">

                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Update Rootstock for {{ $crop->crop }}</h3>
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

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-warning">Update Rootstock</button>
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
