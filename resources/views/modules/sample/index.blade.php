@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Samples</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('sample.create') }}" class="btn btn-primary">
                                Book Test
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
                                            <span class="text-success font-weight-bold">Paid</span>
                                        @elseif($sample->sample_status == 'pending')
                                            <span class="text-warning font-weight-bold">Pending Payment</span>
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
                                            class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a> --}}
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
