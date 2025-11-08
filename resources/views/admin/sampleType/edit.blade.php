@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Update Sample Type</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Test Configuration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sample-types') }}">Sample Types</a></li>
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
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-clipboard-data me-2"></i>Update Sample Type</h3>
                </div>
                    <form action="{{ route('admin.sample-types.update', $sample_type->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div style="padding: 15px;">
                                <div class='row'>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Sample Type <span style="color: #777777;">*</span></label>
                                            <input type="text" name="e_type" class="form-control"
                                                value="{{ old('e_type', $sample_type->e_type) }}" required>
                                        </div>
                                    </div>
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">H Type</label>
                                        <input type="text" name="h_type" class="form-control"
                                            value="{{ old('h_type', $sample_type->h_type) }}" required>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Sample Size <span style="color: #777777;">*</span></label>
                                        <input type="text" name="sample_size" class="form-control"
                                            value="{{ old('sample_size', $sample_type->sample_size) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Buffer Size</label>
                                        <input type="text" name="buffer_size" class="form-control"
                                            value="{{ old('buffer_size', $sample_type->buffer_size) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Batch Prefix</label>
                                        <input type="text" name="batch_prefix" class="form-control"
                                            value="{{ old('batch_prefix', $sample_type->batch_prefix) }}">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="bi bi-save me-1"></i> Update
                                    </button>
                                    <a href="{{ route('admin.sample-types') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
