@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Create Crop</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.crops') }}">Crops</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-flower1 me-2"></i> Create Crop</h3>
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
                    <form action="{{ route('admin.crops.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div style="padding: 15px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cat" class="form-label fw-semibold">Crop Category <span
                                                    style="color: #777777;">*</span></label>
                                            <select name="cat" id="cat" class="form-select" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->e_cat }}</option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">
                                                <a href="{{ route('admin.crop.categories.create') }}" target="_blank" class="text-muted text-decoration-none">
                                                    + Add New Category
                                                </a>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label fw-semibold">Crop Type <span
                                                    style="color: #777777;">*</span></label>
                                            <select name="type" id="type" class="form-select" required>
                                                <option value="">Select Type</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->e_type }}</option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">
                                                <a href="{{ route('admin.crop.types.create') }}" target="_blank" class="text-muted text-decoration-none">
                                                    + Add New Type
                                                </a>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="crop" class="form-label fw-semibold">Crop Name <span style="color: #777777;">
                                                    *</span></label>
                                            <input type="text" name="crop" id="crop" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="aging" class="form-label fw-semibold">Age of crop <span style="color: #777777;">
                                                    *</span></label>
                                            <input type="text" name="aging" id="aging" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="variety" class="form-label fw-semibold">Variety <span
                                                    style="color: #777777;">*</span></label>
                                            <select name="variety" id="variety" class="form-select" required>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="rootstock" class="form-label fw-semibold">Rootstock <span
                                                    style="color: #777777;">*</span></label>
                                            <select name="rootstock" id="rootstock" class="form-select" required>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-save me-1"></i> Save Crop
                                </button>
                                <a href="{{ route('admin.crops') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
