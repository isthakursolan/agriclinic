@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Update Roles - {{ $user->name ?? $user->username }}</h3>
                </div>
                <form action="{{ route('admin.roles.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Roles</label>
                            <select name="role[]" class="form-control" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold <b>Ctrl</b> (Windows) or <b>Cmd</b> (Mac) to select multiple roles.</small>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success">Save</button>
                        <a href="{{ route('admin.roles') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
