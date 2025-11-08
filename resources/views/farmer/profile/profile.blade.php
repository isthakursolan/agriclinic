@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Update Profile</h3>
                    </div>
                    <form action="{{ route('user.profile.store', $profile->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="fullname" class="form-control"
                                            value="{{ old('fullname', $profile->fullname ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ old('username', $profile->username ?? '') }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label><br>
                                        <label>
                                            <input type="radio" name="gender" value="male"
                                                {{ old('gender', $profile->gender ?? '') == 'male' ? 'checked' : '' }}>
                                            Male
                                        </label>

                                        <label>
                                            <input type="radio" name="gender" value="female"
                                                {{ old('gender', $profile->gender ?? '') == 'female' ? 'checked' : '' }}>
                                            Female
                                        </label>

                                        <label>
                                            <input type="radio" name="gender" value="other"
                                                {{ old('gender', $profile->gender ?? '') == 'other' ? 'checked' : '' }}>
                                            Other
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $profile->email ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID Type</label>
                                        <select name="id_type" class="form-select">
                                            <option value="">-- Select ID Type --</option>
                                            <option value="aadhar" {{ old('id_type') == 'aadhar' ? 'selected' : '' }}>Aadhar
                                            </option>
                                            <option value="PAN" {{ old('id_type') == 'PAN' ? 'selected' : '' }}>PAN
                                            </option>
                                            <option value="Voter ID"{{ old('id_type') == 'Voter ID' ? 'selected' : '' }}>
                                                Voter ID</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID Number</label>
                                        <input type="text" name="id_no"
                                            value="{{ old('id_no', $profile->id_no ?? '') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact</label>
                                        <input type="text" id="contact" name="contact"
                                            value="{{ old('contact', $profile->contact ?? '') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Qualification</label>
                                        <input type="text" name="qualification"
                                            value="{{ old('qualification', $profile->qualification ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">WhatsApp</label>
                                        <input type="text" id="whatsapp" name="whatsapp"
                                            value="{{ old('whatsapp', $profile->whatsapp ?? '') }}" class="form-control">
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="contact_same_as_whatsapp" value="1"
                                            class="form-check-input" id="sameAsContact">
                                        <label class="form-check-label" for="sameAsContact">Same as Contact</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control">{{ old('address', $profile->address ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">District</label>
                                        <input type="text" name="district"
                                            value="{{ old('district', $profile->district ?? '') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state"
                                            value="{{ old('state', $profile->state ?? '') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Post Office</label>
                                        <input type="text" name="postoffice"
                                            value="{{ old('postoffice', $profile->postoffice ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" name="pincode"
                                            value="{{ old('pincode', $profile->pincode ?? '') }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Land Area Cultivated</label>
                                        <input type="text" name="land_area_cultivated"
                                            value="{{ old('land_area_cultivated', $profile->land_area_cultivated ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Land Area Total</label>
                                        <input type="text" name="land_area_total"
                                            value="{{ old('land_area_total', $profile->land_area_total ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Referred By</label>
                                        <input type="text" name="referred_by"
                                            value="{{ old('referred_by', $profile->referred_by ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Farming Since</label>
                                        <input type="text" name="farming_since"
                                            value="{{ old('farming_since', $profile->farming_since ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Crop Grown</label>
                                        <textarea name="crop_grown" class="form-control">{{ old('crop_grown', $profile->crop_grown ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Info on All Crops</label>
                                        <textarea name="info_on_all_crops" class="form-control">{{ old('info_on_all_crops', $profile->info_on_all_crops ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Capital Investment</label>
                                        <input type="text" name="capital_investment"
                                            value="{{ old('capital_investment', $profile->capital_investment ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Technology Intervention</label>
                                        <textarea name="technology_intervention" class="form-control">{{ old('technology_intervention', $profile->technology_intervention ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Future Plans</label>
                                        <textarea name="future_plans" class="form-control">{{ old('future_plans', $profile->future_plans ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Submit</button>
                            <a href="{{ route('user.profile') }}" class="btn btn-secondary">Cancel</a>
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

                // Update WhatsApp automatically if contact changes
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
