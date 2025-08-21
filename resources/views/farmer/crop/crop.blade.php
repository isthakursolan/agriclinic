@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Crops</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('user.add.crop') }}" class="btn btn-primary">
                                Add Crop
                            </a>
                        </div>
                    </div>

                    <table id="myDataTable" class="display table table-bordered table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>Field Name</th>
                                <th>Crop</th>
                                <th>Type</th>
                                <th>Variety</th>
                                <th>Rootstock</th>
                                <th>Sowing Date</th>
                                <th>Harvest Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crops as $crop)
                                <tr>
                                    <td>
                                        @foreach ($plots as $plot)
                                            @if ($crop->plot_id == $plot->id)
                                                {{ $plot->field_name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $crop->name }}</td>
                                    <td>{{ $crop->crop_cat }}</td>
                                    <td>{{ $crop->variety ?? '-' }}</td>
                                    <td>{{ $crop->rootstock ?? '-' }}</td>
                                    <td>{{ $crop->sowing_date }}</td>
                                    <td>{{ $crop->expected_harvest_date }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning">
                                            Edit Field
                                        </a>
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
