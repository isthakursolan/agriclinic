@extends('auth.app')

@section('content')
    <div class="register-page bg-body-secondary">
        <div class="register-box">
            <div class="card card-outline card-primary shadow">
                <div class="card-header text-center">
                    <h1 class="brand-title">🌱 AgriClinic</h1>
                    <p class="brand-subtitle">Smart Farming & Crop Management</p>
                </div>
                <div class="card-body register-card-body">
                    <p class="register-box-msg">Create your account to get started</p>

                    <form action="{{ route('register.store') }}" method="post">
                        @csrf
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input id="registerFullName" type="text" name="name" class="form-control"
                                    placeholder="" />
                                <label for="registerFullName">Full Name</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person"></span></div>
                        </div>

                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input id="email" type="email" name="email" class="form-control" placeholder="" />
                                <label for="registerEmail">Email</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>

                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input id="contact" type="text" name="contact" class="form-control" placeholder="" />
                                <label for="contact">Contact No.</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-phone"></span></div>
                        </div>

                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input id="registerPassword" type="password" name="password" class="form-control"
                                    placeholder="" />
                                <label for="registerPassword">Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>

                        <div class="input-group mb-3">
                            <div class="form-floating">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    class="form-control" placeholder="" />
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-8 d-inline-flex align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <p class="mb-0 text-center">
                        Already have an account? <a href="{{ route('login') }}" class="link-primary">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
