@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Crop Varieties & Rootstocks</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Crop Varieties & Rootstocks</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"> <i class="bi bi-flower1 me-2"></i> Crop Varieties & Rootstocks</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.crop-varieties.create') }}" class="btn btn-dark mb-3"><i class="bi bi-plus-circle me-2"></i>Add Relations</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Crop</th>
                                    <th>Varieties</th>
                                    <th>Rootstocks</th>
                                    <th class="text-center">Action</th>
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
                                        <td class="text-center">
                                            <a href="{{ route('admin.crop-varieties.edit', $crop->id) }}"
                                                class="btn btn-sm btn-dark" title="Update Relations">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            {{-- <form action="{{ route('admin.crop-varieties.destroy', $crop->id) }}" method="POST"
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
        </div>
    </div>
@endsection
