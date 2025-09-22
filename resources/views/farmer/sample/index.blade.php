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
                            <a href="{{ route('user.sample.create') }}" class="btn btn-primary">
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
                            @forelse ($samples as $sample)
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
                                    <td><span
                                            class="badge
                                            @if ($sample->sample_status == 'pending') text-warning
                                            @elseif($sample->sample_status == 'accepted') text-success
                                            @elseif($sample->sample_status == 'paid') text-success
                                            @elseif($sample->sample_status == 'collected') text-info
                                            @else badge-secondary @endif
                                        ">{{ ucfirst($sample->sample_status) }}</span>
                                    </td>
                                    <td>{{ $sample->concern }}</td>
                                    <td class="text-center">
                                        @if ($sample->sample_status == 'pending')
                                            <a href="{{ route('user.payments.show', $sample->id) }}"
                                                class="btn btn-success btn-sm"><i class="fas fa-credit-card"></i> Pay</a>
                                            {{-- <a href="{{ route('user.samples.edit', $sample->id) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a> --}}
                                        @else
                                            <a href="{{ route('user.samples.details', $sample->id) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                        @endif
                                    </td>
                                @empty
                                    <td colspan="8" class="text-center">No samples found.</td>
                                </tr>
                            @endforelse
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
