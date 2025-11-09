@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">User Profile</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">All Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <!-- User Information Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h3 class="card-title mb-0 text-white"><i class="bi bi-person me-2"></i>User Information</h3>
                        </div>
                        <div class="card-body">
                            <div style="padding: 15px;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name</label>
                                    <p class="form-control-plaintext">{{ $user->name ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <p class="form-control-plaintext">{{ $user->email }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Username</label>
                                    <p class="form-control-plaintext">{{ $user->username ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Contact</label>
                                    <p class="form-control-plaintext">{{ $user->contact ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Created At</label>
                                    <p class="form-control-plaintext">{{ $user->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Last Updated</label>
                                    <p class="form-control-plaintext">{{ $user->updated_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h3 class="card-title mb-0 text-white"><i class="bi bi-shield-check me-2"></i>Roles</h3>
                        </div>
                        <div class="card-body">
                            <div style="padding: 15px;">
                                @if($user->roles->count() > 0)
                                    <div class="mb-3">
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-primary me-2 mb-2" style="font-size: 0.9rem; padding: 0.5rem 0.75rem;">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No roles assigned</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Details Card (if exists) -->
            @if($user->profile)
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #777777;">
                                <h3 class="card-title mb-0 text-white"><i class="bi bi-file-person me-2"></i>Profile Details</h3>
                            </div>
                            <div class="card-body">
                                <div style="padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Full Name</label>
                                                <p class="form-control-plaintext">{{ $user->profile->fullname ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Gender</label>
                                                <p class="form-control-plaintext">{{ $user->profile->gender ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Address</label>
                                                <p class="form-control-plaintext">{{ $user->profile->address ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">District</label>
                                                <p class="form-control-plaintext">{{ $user->profile->district ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">State</label>
                                                <p class="form-control-plaintext">{{ $user->profile->state ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Pincode</label>
                                                <p class="form-control-plaintext">{{ $user->profile->pincode ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <div class="d-flex justify-content-start gap-2">
                                    @if($user->hasRole('superadmin'))
                                        <div class="alert alert-warning mb-0">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Cannot impersonate another superadmin.
                                        </div>
                                    @else
                                        <form action="{{ route('admin.impersonate.start', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-dark">
                                                <i class="bi bi-person-badge me-1"></i> Impersonate
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left me-1"></i> Back to Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

