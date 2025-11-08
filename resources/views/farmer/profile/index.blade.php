@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0 text-dark fw-bold">
                        <i style="color: #777777;"></i> Farmer Profile
                    </h2>
                    <a href="{{ route('user.profile.edit', $profile->id) }}" class="btn btn-success shadow-sm">
                        <i class="bi bi-pencil-square me-2"></i> Update Profile
                    </a>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <!-- Personal Info -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-success text-white d-flex align-items-center">
                                <span style="color: #777777;">
                                    <i class="fas fa-user-circle"></i>
                                </span>
                                <h5 class="mb-0 fw-bold">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Full Name:</strong> {{ $profile->fullname }}</p>
                                <p><strong>Username:</strong> {{ $profile->username }}</p>
                                <p><strong>Gender:</strong> {{ ucfirst($profile->gender) }}</p>
                                <p><strong>Email:</strong> {{ $profile->email }}</p>
                                <p><strong>Contact:</strong> {{ $profile->contact }}</p>
                                <p><strong>WhatsApp:</strong> {{ $profile->whatsapp }}</p>
                                <p><strong>Qualification:</strong> {{ $profile->qualification }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-primary text-white d-flex align-items-center">
                                <span style="color: #777777;">
                                    <i class="bi bi-geo-alt me-2"></i>
                                </span>
                                <h5 class="mb-0 fw-bold">Address</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Address:</strong> {{ $profile->address }}</p>
                                <p><strong>District:</strong> {{ $profile->district }}</p>
                                <p><strong>State:</strong> {{ $profile->state }}</p>
                                <p><strong>Post Office:</strong> {{ $profile->postoffice }}</p>
                                <p><strong>Pincode:</strong> {{ $profile->pincode }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Land Info -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-warning text-dark d-flex align-items-center">
                                <span style="color: #777777;">
                                    <i class="fas fa-tractor"></i>
                                </span>
                                <h5 class="mb-0 fw-bold">Land & Farming</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Land Area Cultivated:</strong> {{ $profile->land_area_cultivated }}</p>
                                <p><strong>Land Area Total:</strong> {{ $profile->land_area_total }}</p>
                                <p><strong>Farming Since:</strong> {{ $profile->farming_since }}</p>
                                <p><strong>Referred By:</strong> {{ $profile->referred_by }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Crop Info -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-info text-white d-flex align-items-center">
                                <span class="badge bg-white text-info me-2 p-2 rounded-circle">
                                    <i class="bi bi-flower1 me-2"></i>
                                </span>
                                <h5 class="mb-0 fw-bold">Crop Details</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Crops Grown:</strong> {{ $profile->crop_grown }}</p>
                                <p><strong>Info on All Crops:</strong> {{ $profile->info_on_all_crops }}</p>
                                <p><strong>Capital Investment:</strong> {{ $profile->capital_investment }}</p>
                                <p><strong>Technology Intervention:</strong> {{ $profile->technology_intervention }}</p>
                                <p><strong>Future Plans:</strong> {{ $profile->future_plans }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
