@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-flower1 me-2"></i> Crops</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('user.add.crop') }}" class="btn btn-dark mb-3">
                                <i class="bi bi-plus-circle me-2"></i>Add Crop
                            </a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="myDataTable" class="display datatable table table-bordered table-striped">
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
                                        <a href="{{ route('user.edit.crop', $crop->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-square me-2"></i>Update
                                        </a>
                                        {{-- <form action="{{ route('user.crop.destroy', $crop->id) }}" method="get" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure to delete this crop?')">
                                            <i class="fas fa-trash"></i>Delete
                                        </button>
                                    </form> --}}
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
