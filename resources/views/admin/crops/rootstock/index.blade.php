@extends('layouts.app')
@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title"> <i class="fas fa-seedling"></i> Rootstocks List</h3>
                    </div>
                    <div class="row">
                        <div class="col text-end m-1">
                            <a href="{{ route('admin.rootstock.create') }}" class="btn btn-primary">Add Rootstock</a>
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
                                                class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Update All</a>
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
        </section>
    </div>
@endsection
