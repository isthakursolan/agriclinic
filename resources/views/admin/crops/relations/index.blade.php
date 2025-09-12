@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title"> <i class="fas fa-seedling"></i> Crop Varieties & Rootstocks</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.crops.create') }}" class="btn btn-primary">Add
                                Relations</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Crop</th>
                                    <th>Varieties</th>
                                    <th>Rootstocks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($crops as $crop)
                                    <tr>
                                        <td>{{ $crop->crop }}</td>
                                        <td>
                                            @forelse($crop->varieties as $v)
                                                <span class="badge bg-info">{{ $v->variety }}</span>
                                            @empty
                                                <span class="text-muted">None</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            @forelse($crop->rootstocks as $r)
                                                <span class="badge bg-warning">{{ $r->rootstock }}</span>
                                            @empty
                                                <span class="text-muted">None</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.crops.edit', $crop->id) }}"
                                                class="btn btn-sm btn-primary">Update</a>
                                            {{-- <form action="{{ route('admin.crops.destroy', $crop->id) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete all relations for this crop?')">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
