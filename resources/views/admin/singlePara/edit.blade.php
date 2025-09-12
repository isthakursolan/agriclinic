@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Parameter</h3>
                    </div>
                    <form action="{{ route('admin.singlePara.update', $parameter->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Parameter</label>
                                        <input type="text" name="parameter" class="form-control"
                                            value="{{ old('parameter', $parameter->parameter) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Symbol</label>
                                        <input type="text" name="symbol" class="form-control"
                                            value="{{ old('symbol', $parameter->symbol) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Reporting Time</label>
                                        <input type="text" name="reporting_time" class="form-control"
                                            value="{{ old('reporting_time', $parameter->reporting_time) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control"
                                            value="{{ old('price', $parameter->price) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Sample Type</label>
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
                                        <label>Reading Type</label>
                                        <input type="text" name="reading_type" class="form-control"
                                            value="{{ old('reading_type', $parameter->reading_type) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
