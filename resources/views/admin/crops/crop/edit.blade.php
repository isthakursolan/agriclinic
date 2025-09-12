@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Update Crop</h3>
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

                <!-- Update form -->
                <form action="{{ route('admin.crop.update', $crop->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <!-- Crop Category -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cat" class="form-label">Crop Category <span class="text-danger">*</span></label>
                                    <select name="cat" id="cat" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $crop->cat == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->e_cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Crop Type -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Crop Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">Select Type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}" {{ $crop->type == $type->id ? 'selected' : '' }}>
                                                {{ $type->e_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Crop Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="crop" class="form-label">Crop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="crop" id="crop" class="form-control" value="{{ $crop->crop }}" required>
                                </div>
                            </div>

                            <!-- Age of Crop -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aging" class="form-label">Age of Crop <span class="text-danger">*</span></label>
                                    <input type="text" name="aging" id="aging" class="form-control" value="{{ $crop->aging }}" required>
                                </div>
                            </div>

                            <!-- Variety -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="variety" class="form-label">Variety <span class="text-danger">*</span></label>
                                    <select name="variety" id="variety" class="form-control" required>
                                        <option value="0" {{ $crop->variety == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $crop->variety == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Rootstock -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rootstock" class="form-label">Rootstock <span class="text-danger">*</span></label>
                                    <select name="rootstock" id="rootstock" class="form-control" required>
                                        <option value="0" {{ $crop->rootstock == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $crop->rootstock == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Crop</button>
                        <a href="{{ route('admin.crop') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
@endsection
