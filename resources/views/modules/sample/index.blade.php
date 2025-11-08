@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Samples</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('sample.create') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Book Test
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="myDataTable" class=" datatable display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>Sample Code</th>
                                <th>Crop</th>
                                <th>Field</th>
                                <th>Sample Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Concern</th>
                                <th>Action</th>
                                {{-- <th>Investigations</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($samples as $sample)
                                <tr>
                                    <td>{{ $sample->sample_id }}</td>
                                    <td>
                                        @foreach ($crop as $c)
                                            @if ($sample->crop_id === $c->id)
                                                {{ $c->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($field as $f)
                                            @if ($sample->field_id === $f->id)
                                                {{ $f->field_name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($type as $s)
                                            @if ($sample->sample_type == $s->id)
                                                {{ $s->e_type }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $sample->amount }}</td>
                                    <td>
                                        @if ($sample->sample_status == 'paid')
                                            <span style="color: #777777;">Paid</span>
                                        @elseif($sample->sample_status == 'pending')
                                            <span style="color: #777777;">Pending Payment</span>
                                        @else
                                            <span
                                                class="text-info font-weight-bold">{{ ucfirst($sample->sample_status) }}</span>
                                        @endif
                                    </td>
                                    {{-- <td>{{ $sample->sample_status }}</td> --}}
                                    <td>{{ $sample->concern }}</td>
                                    <td>
                                        Button
                                        {{-- <a href="{{ route('sample.edit', $sample->sample_id) }}"
                                            class="btn btn-sm btn-info"><i class="bi bi-pencil-square me-2"></i> Edit</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>
@endsection
