@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Update Result</h3>
                    </div>
                     @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    <form action="{{ route('lab.parameters.update', $investigation->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_name">Sample Id</label>
                                        <input type="text" class="form-control" name="smaple_id" readonly
                                            value="{{ $investigation->sample_id }}">
                                    </div>
                                </div>
                                <!-- Area -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="area">Parameter</label>
                                        <input type="text" class="form-control" name="parameter" readonly
                                            value="{{ $parameter->parameter }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reading1">Reading 1</label>
                                        <input type="text" class="form-control" name="reading1" id="reading1"
                                            value="{{ $investigation->reading1 }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reading2">Reading 2</label>
                                        <input type="text" class="form-control" name="reading2" id="reading2"
                                            value="{{ $investigation->reading2 }}">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Dilusion</label>
                                    <input type="text" name="dilusion" class="form-control"
                                        value="{{ $investigation->dilusion }}">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Result</label>
                                    <input name="result" class="form-control" value="{{ $investigation->result }}">
                                </div>
                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="interpretation">Interpretation</label>
                                        <textarea class="form-control" name="interpretation" id="interpretation" rows="3">{{ $investigation->interpretation }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
                            <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
