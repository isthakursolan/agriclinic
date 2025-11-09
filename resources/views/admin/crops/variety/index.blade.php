@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Varieties</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Crops</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Varieties</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-flower1 me-2"></i>Varieties</h3>
                </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.variety.create') }}" class="btn btn-dark mb-3"><i class="bi bi-plus-circle me-2"></i>Create New</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class=" datatable table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Crop</th>
                                    <th>Variety Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($crops as $index => $crop)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $crop->crop }}</td>
                                        <td>
                                            @if ($crop->varieties->count())
                                                <ul>
                                                    @foreach ($crop->varieties as $variety)
                                                        <li>
                                                            {{ $variety->variety }}
                                                            {{-- <form
                                                                action="{{ route('admin.variety.destroySingle', $variety->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Delete this variety?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form> --}}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">No Varieties</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.variety.edit', $crop->id) }}"
                                                class="btn btn-sm btn-warning"><i class="bi bi-pencil-square me-2"></i> Update All</a>
                                            {{-- <form action="{{ route('admin.variety.destroy', $crop->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete all varieties?')">
                                                    <i class="fas fa-trash"></i> Delete All
                                                </button>
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
