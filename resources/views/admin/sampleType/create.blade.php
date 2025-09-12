@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Add Sample Type</h3>
                    </div>
                    <form action="{{ route('admin.sampleType.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Sample Type</label>
                                        <input type="text" name="e_type" class="form-control"
                                            value="{{ old('e_type') }}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>H Type</label>
                                        <input type="text" name="h_type" class="form-control"
                                            value="{{ old('h_type') }}" required>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Sample Size</label>
                                        <input type="text" name="sample_size" class="form-control"
                                            value="{{ old('sample_size') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Buffer Size</label>
                                        <input type="text" name="buffer_size" class="form-control"
                                            value="{{ old('buffer_size') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Batch Prefix</label>
                                        <input type="text" name="batch_prefix" class="form-control"
                                            value="{{ old('batch_prefix') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
