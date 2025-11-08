@extends('layouts.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Rootstocks</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Rootstocks</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"> <i class="bi bi-flower1 me-2"></i> Rootstocks List</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.rootstock.create') }}" class="btn btn-dark mb-3"><i class="bi bi-plus-circle me-2"></i>Add Rootstock</a>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered datatable table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Crop</th>
                                    <th>Rootstocks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($crops as $index => $crop)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $crop->crop }}</td>
                                        <td>
                                            @if ($crop->rootstocks->count())
                                                <ul>
                                                    @foreach ($crop->rootstocks as $root)
                                                        <li>
                                                            {{ $root->rootstock }}
                                                            <form
                                                                action="{{ route('admin.rootstock.destroySingle', $root->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Delete this rootstock?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">No Rootstocks</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.rootstock.', $crop->id) }}"
                                                class="btn btn-sm btn-warning"><i class="bi bi-pencil-square me-2"></i> Update All</a>
                                            <form action="{{ route('admin.rootstock.destroy', $crop->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete all rootstocks?')">
                                                    <i class="fas fa-trash"></i> Delete All
                                                </button>
                                            </form>
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
