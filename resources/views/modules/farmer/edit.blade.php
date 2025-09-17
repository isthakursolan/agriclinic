@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-edit"></i> Update Farmer</h3>
                    </div>

                    <form action="{{ route('farmer.update', $farmer->id) }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                {{-- Full Name --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="fullname" class="form-control"
                                            value="{{ old('fullname', $farmer->profile->fullname ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- Username --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ old('username', $farmer->username ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $farmer->email ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- Password (optional update) --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password (leave blank to keep current)</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>

                                {{-- Contact --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact</label>
                                        <input type="text" id="contact" name="contact" class="form-control"
                                            value="{{ old('contact', $farmer->contact ?? '') }}" required>
                                    </div>
                                </div>

                                {{-- WhatsApp --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">WhatsApp</label>
                                        <input type="text" id="whatsapp" name="whatsapp" class="form-control"
                                            value="{{ old('whatsapp', $farmer->profile->whatsapp ?? '') }}">
                                        <div class="form-check mt-1">
                                            <input type="checkbox" name="contact_same_as_whatsapp" value="1"
                                                class="form-check-input" id="sameAsContact"
                                                {{ old('whatsapp', $farmer->profile->whatsapp ?? '') == $farmer->contact ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sameAsContact">Same as Contact</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gender</label><br>
                                        <label>
                                            <input type="radio" name="gender" value="male"
                                                {{ old('gender', $farmer->profile->gender ?? '') == 'male' ? 'checked' : '' }}>
                                            Male
                                        </label>

                                        <label>
                                            <input type="radio" name="gender" value="female"
                                                {{ old('gender', $farmer->profile->gender ?? '') == 'female' ? 'checked' : '' }}>
                                            Female
                                        </label>

                                        <label>
                                            <input type="radio" name="gender" value="other"
                                                {{ old('gender', $farmer->profile->gender ?? '') == 'other' ? 'checked' : '' }}>
                                            Other
                                        </label>
                                    </div>
                                </div>
                                {{-- Example more fields (repeat same style) --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Qualification</label>
                                        <input type="text" name="qualification" class="form-control"
                                            value="{{ old('qualification', $farmer->profile->qualification ?? '') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control">{{ old('address', $farmer->profile->address ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">District</label>
                                        <input type="text" name="district"
                                            value="{{ old('district', $farmer->profile->district ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">State</label>
                                        <input type="text" name="state"
                                            value="{{ old('state', $farmer->profile->state ?? '') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Post Office</label>
                                        <input type="text" name="postoffice"
                                            value="{{ old('postoffice', $farmer->profile->postoffice ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" name="pincode"
                                            value="{{ old('pincode', $farmer->profile->pincode ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Land Area Cultivated</label>
                                        <input type="text" name="land_area_cultivated"
                                            value="{{ old('land_area_cultivated', $farmer->profile->land_area_cultivated ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Land Area Total</label>
                                        <input type="text" name="land_area_total"
                                            value="{{ old('land_area_total', $farmer->profile->land_area_total ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Referred By</label>
                                        <input type="text" name="referred_by"
                                            value="{{ old('referred_by', $farmer->profile->referred_by ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Farming Since</label>
                                        <input type="text" name="farming_since"
                                            value="{{ old('farming_since', $farmer->profile->farming_since ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Crop Grown</label>
                                        <textarea name="crop_grown" class="form-control">{{ old('crop_grown', $farmer->profile->crop_grown ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Info on All Crops</label>
                                        <textarea name="info_on_all_crops"
                                            class="form-control">{{ old('info_on_all_crops', $farmer->profile->info_on_all_crops ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Capital Investment</label>
                                        <input type="text" name="capital_investment"
                                            value="{{ old('capital_investment', $farmer->profile->capital_investment ?? '') }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Technology Intervention</label>
                                        <textarea name="technology_intervention"
                                            class="form-control">{{ old('technology_intervention', $farmer->profile->technology_intervention ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Future Plans</label>
                                        <textarea name="future_plans" class="form-control"
                                            > {{ old('future_plans', $farmer->profile->future_plans ?? '') }}</textarea>
                                    </div>
                                </div>
                                {{-- Continue with district, state, pincode, land, crops, etc. same as Add form --}}
                                {{-- Just replace $profile->field with $farmer->profile->field --}}
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Farmer
                            </button>
                             <a href="{{ route('farmers') }}" class="btn btn-secondary">Cancel</a>
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
