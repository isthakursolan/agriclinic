@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('frontoffice.farmers.update', $farmer->id) }}" method="POST">
                    @csrf

                    <!-- Login Credentials -->
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h3 class="card-title mb-0 text-white"><i class="bi bi-key me-2"></i>Login Credentials</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Full Name <span style="color: #777777;">*</span></label>
                                        <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $farmer->profile->fullname ?? $farmer->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Username <span style="color: #777777;">*</span></label>
                                        <input type="text" name="username" class="form-control" value="{{ old('username', $farmer->username) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Email <span style="color: #777777;">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $farmer->email) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Contact Number <span style="color: #777777;">*</span></label>
                                        <input type="text" name="contact" class="form-control" value="{{ old('contact', $farmer->contact) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>New Password (leave blank to keep current)</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="card card-info">
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h3 class="card-title mb-0 text-white"><i class="bi bi-person me-2"></i>Personal Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>WhatsApp Number</label>
                                        <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $farmer->profile->whatsapp ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $farmer->profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $farmer->profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $farmer->profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>ID Type</label>
                                        <input type="text" name="id_type" class="form-control" value="{{ old('id_type', $farmer->profile->id_type ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>ID Number</label>
                                        <input type="text" name="id_no" class="form-control" value="{{ old('id_no', $farmer->profile->id_no ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="card card-secondary">
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i>Address Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control">{{ old('address', $farmer->profile->address ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>District</label>
                                        <input type="text" name="district" class="form-control" value="{{ old('district', $farmer->profile->district ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control" value="{{ old('state', $farmer->profile->state ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Pincode</label>
                                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $farmer->profile->pincode ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Post Office</label>
                                        <input type="text" name="postoffice" class="form-control" value="{{ old('postoffice', $farmer->profile->postoffice ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Farming Information -->
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #777777;">
                            <h3 class="card-title mb-0 text-white"><i class="bi bi-flower1 me-2"></i>Farming Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Referred By</label>
                                        <input type="text" name="referred_by" class="form-control" value="{{ old('referred_by', $farmer->profile->referred_by ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Crops Grown</label>
                                        <input type="text" name="crop_grown" class="form-control" value="{{ old('crop_grown', $farmer->profile->crop_grown ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Land Area Cultivated (in acres)</label>
                                        <input type="text" name="land_area_cultivated" class="form-control" value="{{ old('land_area_cultivated', $farmer->profile->land_area_cultivated ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Total Land Area (in acres)</label>
                                        <input type="text" name="land_area_total" class="form-control" value="{{ old('land_area_total', $farmer->profile->land_area_total ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Farming Since (Year)</label>
                                        <input type="text" name="farming_since" class="form-control" value="{{ old('farming_since', $farmer->profile->farming_since ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Technology Intervention</label>
                                        <input type="text" name="technology_intervention" class="form-control" value="{{ old('technology_intervention', $farmer->profile->technology_intervention ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Capital Investment</label>
                                        <input type="text" name="capital_investment" class="form-control" value="{{ old('capital_investment', $farmer->profile->capital_investment ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Future Plans</label>
                                        <input type="text" name="future_plans" class="form-control" value="{{ old('future_plans', $farmer->profile->future_plans ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Info on All Crops</label>
                                        <input type="text" name="info_on_all_crops" class="form-control" value="{{ old('info_on_all_crops', $farmer->profile->info_on_all_crops ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <div style="padding: 15px;">
                            <a href="{{ route('frontoffice.farmers.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-dark">Update Farmer</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
