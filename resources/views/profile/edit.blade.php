@extends('layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Edit Profile</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header text-white" style="background-color: #777777;">
                    <h3 class="card-title mb-0 text-white"><i class="bi bi-person-gear me-2"></i>Profile Information</h3>
                </div>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div style="padding: 15px;">
                        <!-- Basic Information -->
                        <h5 class="mb-3 fw-bold" style="color: #777777;">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name <span style="color: #777777;">*</span></label>
                                    <input type="text" name="fullname" class="form-control" 
                                        value="{{ old('fullname', $profile->fullname ?? $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Username <span style="color: #777777;">*</span></label>
                                    <input type="text" name="username" class="form-control" 
                                        value="{{ old('username', $user->username) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email <span style="color: #777777;">*</span></label>
                                    <input type="email" name="email" class="form-control" 
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Contact Number <span style="color: #777777;">*</span></label>
                                    <input type="text" name="contact" class="form-control" 
                                        value="{{ old('contact', $user->contact) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Name (User Account)</label>
                                    <input type="text" name="name" class="form-control" 
                                        value="{{ old('name', $user->name) }}" required>
                                    <small class="text-muted">This is your account name</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">-- Select Gender --</option>
                                        <option value="male" {{ old('gender', $profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Password Change -->
                        <hr class="my-4">
                        <h5 class="mb-3 fw-bold" style="color: #777777;">Change Password</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" class="form-control" 
                                        placeholder="Leave blank to keep current password">
                                    <small class="text-muted">Minimum 6 characters</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" 
                                        placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>

                        <!-- Identification -->
                        <hr class="my-4">
                        <h5 class="mb-3 fw-bold" style="color: #777777;">Identification</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">ID Type</label>
                                    <select name="id_type" class="form-select">
                                        <option value="">-- Select ID Type --</option>
                                        <option value="aadhar" {{ old('id_type', $profile->id_type ?? '') == 'aadhar' ? 'selected' : '' }}>Aadhar</option>
                                        <option value="PAN" {{ old('id_type', $profile->id_type ?? '') == 'PAN' ? 'selected' : '' }}>PAN</option>
                                        <option value="Voter ID" {{ old('id_type', $profile->id_type ?? '') == 'Voter ID' ? 'selected' : '' }}>Voter ID</option>
                                        <option value="Driving License" {{ old('id_type', $profile->id_type ?? '') == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">ID Number</label>
                                    <input type="text" name="id_no" class="form-control" 
                                        value="{{ old('id_no', $profile->id_no ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <hr class="my-4">
                        <h5 class="mb-3 fw-bold" style="color: #777777;">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">WhatsApp Number</label>
                                    <input type="text" id="whatsapp" name="whatsapp" class="form-control" 
                                        value="{{ old('whatsapp', $profile->whatsapp ?? '') }}">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="contact_same_as_whatsapp" value="1" 
                                            class="form-check-input" id="sameAsContact">
                                        <label class="form-check-label" for="sameAsContact">Same as Contact Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Qualification</label>
                                    <input type="text" name="qualification" class="form-control" 
                                        value="{{ old('qualification', $profile->qualification ?? '') }}" 
                                        placeholder="e.g., B.Sc. Agriculture">
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <hr class="my-4">
                        <h5 class="mb-3 fw-bold" style="color: #777777;">Address Information</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Address</label>
                                    <textarea name="address" class="form-control" rows="2">{{ old('address', $profile->address ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">District</label>
                                    <input type="text" name="district" class="form-control" 
                                        value="{{ old('district', $profile->district ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">State</label>
                                    <input type="text" name="state" class="form-control" 
                                        value="{{ old('state', $profile->state ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pincode</label>
                                    <input type="text" name="pincode" class="form-control" 
                                        value="{{ old('pincode', $profile->pincode ?? '') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Post Office</label>
                                    <input type="text" name="postoffice" class="form-control" 
                                        value="{{ old('postoffice', $profile->postoffice ?? '') }}">
                                </div>
                            </div>
                        </div>

                        @if(Auth::user()->hasRole('farmer'))
                            <!-- Farmer-Specific Information -->
                            <hr class="my-4">
                            <h5 class="mb-3 fw-bold" style="color: #777777;">Farming Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Referred By</label>
                                        <input type="text" name="referred_by" class="form-control" 
                                            value="{{ old('referred_by', $profile->referred_by ?? '') }}" 
                                            placeholder="Who referred you to us?">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Farming Since</label>
                                        <input type="text" name="farming_since" class="form-control" 
                                            value="{{ old('farming_since', $profile->farming_since ?? '') }}" 
                                            placeholder="e.g., 2010">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Land Area Cultivated (acres)</label>
                                        <input type="text" name="land_area_cultivated" class="form-control" 
                                            value="{{ old('land_area_cultivated', $profile->land_area_cultivated ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Total Land Area (acres)</label>
                                        <input type="text" name="land_area_total" class="form-control" 
                                            value="{{ old('land_area_total', $profile->land_area_total ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Capital Investment</label>
                                        <input type="text" name="capital_investment" class="form-control" 
                                            value="{{ old('capital_investment', $profile->capital_investment ?? '') }}" 
                                            placeholder="e.g., ₹50,000">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Crop Grown</label>
                                        <textarea name="crop_grown" class="form-control" rows="3">{{ old('crop_grown', $profile->crop_grown ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Info on All Crops</label>
                                        <textarea name="info_on_all_crops" class="form-control" rows="3">{{ old('info_on_all_crops', $profile->info_on_all_crops ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Technology Intervention</label>
                                        <textarea name="technology_intervention" class="form-control" rows="3">{{ old('technology_intervention', $profile->technology_intervention ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Future Plans</label>
                                        <textarea name="future_plans" class="form-control" rows="3">{{ old('future_plans', $profile->future_plans ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <div style="padding: 15px;">
                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-save me-1"></i> Update Profile
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sameAsContactCheckbox = document.getElementById('sameAsContact');
            const contactInput = document.querySelector('input[name="contact"]');
            const whatsappInput = document.getElementById('whatsapp');

            if (sameAsContactCheckbox && contactInput && whatsappInput) {
                sameAsContactCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        whatsappInput.value = contactInput.value;
                        whatsappInput.setAttribute('readonly', true);
                        
                        contactInput.addEventListener('input', function() {
                            if (sameAsContactCheckbox.checked) {
                                whatsappInput.value = this.value;
                            }
                        });
                    } else {
                        whatsappInput.removeAttribute('readonly');
                    }
                });
            }
        });
    </script>
@endsection

