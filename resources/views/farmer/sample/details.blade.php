@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-vial me-2"></i> Sample Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Sample ID:</strong> {{ $sample->sample_id }}</p>
                                <p><strong>Farmer:</strong> {{ $sample->farmer->fullname }}</p>
                                <p><strong>Field:</strong> {{ $sample->field->field_name }}</p>
                                <p><strong>Crop:</strong> {{ $sample->crop->crop->crop_name ?? 'N/A' }}</p>
                                <p><strong>Sample Type:</strong> {{ $sample->sampleType->e_type }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong> <span
                                        class="badge badge-{{ $sample->sample_status == 'pending' ? 'warning' : ($sample->sample_status == 'paid' ? 'success' : 'info') }}">{{ ucfirst($sample->sample_status) }}</span>
                                </p>
                                <p><strong>Concern:</strong> {{ $sample->concern }}</p>
                                <p><strong>Collection Method:</strong> {{ ucfirst($sample->collection_method) }}</p>
                                @if ($payment)
                                    <p><strong>Payment Status:</strong> Paid</p>
                                    <p><strong>Payment Mode:</strong> {{ $payment->mode }}</p>
                                    <p><strong>Transaction ID:</strong> {{ $payment->transaction_id ?? 'N/A' }}</p>
                                @else
                                    <p><strong>Payment Status:</strong> Not Paid</p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <h4>Parameters &amp; Packages</h4>
                        <div class="row">
                            <div class="col-md-6">
                                @if ($sample->package)
                                    <p><strong>Package:</strong>
                                        {{ \App\Models\packagesModel::find($sample->package)->package_name ?? 'N/A' }}
                                    </p>
                                @endif
                                @if (!empty($sample->parameters))
                                    <p><strong>Parameters:</strong>
                                        {{ \App\Models\individualParameterModel::whereIn('id', $sample->parameters)->pluck('parameter')->implode(', ') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <h4>Investigation Results</h4>
                        @if ($sample->investigations->count() > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Result</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sample->investigations as $investigation)
                                        <tr>
                                            <td>{{ $investigation->parameters->parameter ?? 'N/A' }}</td>
                                            <td>{{ $investigation->result ?? 'Pending' }}</td>
                                            <td>{{ $investigation->parameters->unit ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Investigation results are not yet available.</p>
                        @endif
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('user.sample') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                            Back</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
