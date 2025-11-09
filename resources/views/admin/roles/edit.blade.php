@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-pencil-square me-2"></i>Update Roles - {{ $user->name ?? $user->username }}</h3>
                </div>
                <form action="{{ route('admin.roles.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div style="padding: 15px;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Select Roles <span style="color: #777777;">*</span></label>
                                <select name="role[]" class="form-select" multiple required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Hold <b>Ctrl</b> (Windows) or <b>Cmd</b> (Mac) to select multiple roles.</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div style="padding: 15px;">
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-save me-1"></i> Save
                                </button>
                                <a href="{{ route('admin.roles') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
