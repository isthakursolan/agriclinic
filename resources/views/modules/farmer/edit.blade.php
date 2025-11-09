@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-person-gear me-2"></i> Update Farmer</h3>
                    </div>

                    <form action="{{ route('farmer.update', $farmer->id) }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div style="padding: 15px;">
                                <!-- Basic Information -->
                                <h5 class="mb-3 fw-bold" style="color: #777777;">Basic Information</h5>
                                <div class="row">
                                {{-- Full Name --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Full Name <span style="color: #777777;">*</span></label>
                                        <input type="text" name="fullname" class="form-control"
                                            value="{{ old('fullname', $farmer->profile->fullname ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- Username --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Username <span style="color: #777777;">*</span></label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ old('username', $farmer->username ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email <span style="color: #777777;">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $farmer->email ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- Password (optional update) --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                                    </div>
                                </div>

                                {{-- Contact --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Contact <span style="color: #777777;">*</span></label>
                                        <input type="text" id="contact" name="contact" class="form-control"
                                            value="{{ old('contact', $farmer->contact ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- WhatsApp --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">WhatsApp</label>
                                        <input type="text" id="whatsapp" name="whatsapp" class="form-control"
                                            value="{{ old('whatsapp', $farmer->profile->whatsapp ?? '') }}">
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="contact_same_as_whatsapp" value="1"
                                                class="form-check-input" id="sameAsContact"
                                                {{ old('whatsapp', $farmer->profile->whatsapp ?? '') == $farmer->contact ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sameAsContact">Same as Contact</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="">-- Select Gender --</option>
                                            <option value="male" {{ old('gender', $farmer->profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $farmer->profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $farmer->profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Qualification</label>
                                        <input type="text" name="qualification" class="form-control"
                                            value="{{ old('qualification', $farmer->profile->qualification ?? '') }}">
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
                                        <textarea name="address" class="form-control" rows="2">{{ old('address', $farmer->profile->address ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">District</label>
                                        <input type="text" name="district"
                                            value="{{ old('district', $farmer->profile->district ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">State</label>
                                        <input type="text" name="state"
                                            value="{{ old('state', $farmer->profile->state ?? '') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Pincode</label>
                                        <input type="text" name="pincode"
                                            value="{{ old('pincode', $farmer->profile->pincode ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Post Office</label>
                                        <input type="text" name="postoffice"
                                            value="{{ old('postoffice', $farmer->profile->postoffice ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- Farming Information -->
                                <hr class="my-4">
                                <h5 class="mb-3 fw-bold" style="color: #777777;">Farming Information</h5>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Referred By</label>
                                        <input type="text" name="referred_by"
                                            value="{{ old('referred_by', $farmer->profile->referred_by ?? '') }}"
                                            class="form-control" placeholder="Who referred you to us?">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Farming Since</label>
                                        <input type="text" name="farming_since"
                                            value="{{ old('farming_since', $farmer->profile->farming_since ?? '') }}"
                                            class="form-control" placeholder="e.g., 2010">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Land Area Cultivated (acres)</label>
                                        <input type="text" name="land_area_cultivated"
                                            value="{{ old('land_area_cultivated', $farmer->profile->land_area_cultivated ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Total Land Area (acres)</label>
                                        <input type="text" name="land_area_total"
                                            value="{{ old('land_area_total', $farmer->profile->land_area_total ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Capital Investment</label>
                                        <input type="text" name="capital_investment"
                                            value="{{ old('capital_investment', $farmer->profile->capital_investment ?? '') }}"
                                            class="form-control" placeholder="e.g., ₹50,000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Crop Grown</label>
                                        <textarea name="crop_grown" class="form-control" rows="3">{{ old('crop_grown', $farmer->profile->crop_grown ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Info on All Crops</label>
                                        <textarea name="info_on_all_crops" class="form-control" rows="3">{{ old('info_on_all_crops', $farmer->profile->info_on_all_crops ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Technology Intervention</label>
                                        <textarea name="technology_intervention" class="form-control" rows="3">{{ old('technology_intervention', $farmer->profile->technology_intervention ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Future Plans</label>
                                        <textarea name="future_plans" class="form-control" rows="3">{{ old('future_plans', $farmer->profile->future_plans ?? '') }}</textarea>
                                    </div>
                                </div>
                                {{-- Continue with district, state, pincode, land, crops, etc. same as Add form --}}
                                {{-- Just replace $profile->field with $farmer->profile->field --}}
                            </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-save"></i> Update Farmer
                                </button>
                                <a href="{{ route('farmers') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('sameAsContact').addEventListener('change', function() {
            const contactInput = document.getElementById('contact');
            const whatsappInput = document.getElementById('whatsapp');

            if (this.checked) {
                whatsappInput.value = contactInput.value;
                whatsappInput.setAttribute('readonly', true);

                contactInput.addEventListener('input', function() {
                    if (document.getElementById('sameAsContact').checked) {
                        whatsappInput.value = this.value;
                    }
                });
            } else {
                whatsappInput.removeAttribute('readonly');
            }
        });
    </script>
@endsection
