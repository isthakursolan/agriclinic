@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Update Parameter</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Test Configuration</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.test-parameters') }}">Test Parameters</a></li>
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
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-pencil-square me-2"></i>Update Parameter</h3>
                </div>
                    <form action="{{ route('admin.test-parameters.update', $parameter->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div style="padding: 15px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Parameter <span style="color: #777777;">*</span></label>
                                            <input type="text" name="parameter" class="form-control"
                                                value="{{ old('parameter', $parameter->parameter) }}" required>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Symbol</label>
                                        <input type="text" name="symbol" class="form-control"
                                            value="{{ old('symbol', $parameter->symbol) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Reporting Time</label>
                                        <input type="text" name="reporting_time" class="form-control"
                                            value="{{ old('reporting_time', $parameter->reporting_time) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Price <span style="color: #777777;">*</span></label>
                                        <input type="number" name="price" class="form-control"
                                            value="{{ old('price', $parameter->price) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Sample Type <span style="color: #777777;">*</span></label>
                                        <select name="sample_type" class="form-select" required>
                                            <option value="">-- Select Sample Type --</option>
                                            @foreach ($sampleTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ old('sample_type', $parameter->sample_type) == $type->id ? 'selected' : '' }}>
                                                    {{ $type->e_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Reading Type</label>
                                        <input type="text" name="reading_type" class="form-control"
                                            value="{{ old('reading_type', $parameter->reading_type) }}">
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
                                    <a href="{{ route('admin.test-parameters') }}" class="btn btn-secondary">
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
