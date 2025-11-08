@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Update Crop</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.crops') }}">Crops</a></li>
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
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-flower1 me-2"></i> Update Crop</h3>
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
                <form action="{{ route('admin.crops.update', $crop->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div style="padding: 15px;">
                            <div class="row">

                                <!-- Crop Category -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cat" class="form-label">Crop Category <span style="color: #777777;">*</span></label>
                                        <select name="cat" id="cat" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $crop->cat == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->e_cat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">
                                            <a href="{{ route('admin.crop.categories.create') }}" target="_blank" class="text-muted text-decoration-none">
                                                + Add New Category
                                            </a>
                                        </small>
                                    </div>
                                </div>

                                <!-- Crop Type -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Crop Type <span style="color: #777777;">*</span></label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="">Select Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}" {{ $crop->type == $type->id ? 'selected' : '' }}>
                                                    {{ $type->e_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">
                                            <a href="{{ route('admin.crop.types.create') }}" target="_blank" class="text-muted text-decoration-none">
                                                + Add New Type
                                            </a>
                                        </small>
                                    </div>
                                </div>

                                <!-- Crop Name -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="crop" class="form-label">Crop Name <span style="color: #777777;">*</span></label>
                                        <input type="text" name="crop" id="crop" class="form-control" value="{{ $crop->crop }}" required>
                                    </div>
                                </div>

                                <!-- Age of Crop -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="aging" class="form-label">Age of Crop <span style="color: #777777;">*</span></label>
                                        <input type="text" name="aging" id="aging" class="form-control" value="{{ $crop->aging }}" required>
                                    </div>
                                </div>

                                <!-- Variety -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="variety" class="form-label">Variety <span style="color: #777777;">*</span></label>
                                        <select name="variety" id="variety" class="form-control" required>
                                            <option value="0" {{ $crop->variety == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $crop->variety == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Rootstock -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="rootstock" class="form-label">Rootstock <span style="color: #777777;">*</span></label>
                                        <select name="rootstock" id="rootstock" class="form-control" required>
                                            <option value="0" {{ $crop->rootstock == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $crop->rootstock == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="card-footer text-right">
                        <div style="padding: 15px;">
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-save me-1"></i> Update Crop
                                </button>
                                <a href="{{ route('admin.crops') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
