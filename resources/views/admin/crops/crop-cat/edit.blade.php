@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4 col-md-6 mx-auto">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Update Crop Category</h3>
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
                    <form action="{{ route('admin.crop.cat.update', $cropCat->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name</label>
                                <input type="text" name="e_cat" id="e_cat" class="form-control"
                                    value="{{ $cropCat->e_cat }}" required>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update
                                Category</button>
                            <a href="{{ route('admin.crop.cat') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
