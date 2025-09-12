@extends('auth.app')

@section('content')
    <div class="login-box">
        <!-- Logo -->
        <div class="login-logo">
            <a href="#"><b>Agri</b><span>Clinic</span></a>
        </div>
        <!-- Card -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                @if ($errors->has('email'))
                    <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('login.login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email " required />
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required />
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" />
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-muted small">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>

                {{-- <div class="text-center my-3">
        <span class="text-muted">— OR —</span>
      </div> --}}

                <!-- Google Login -->
                {{-- <a href="{{ route('login.google') }}" class="btn btn-google w-100 mb-3">
        <i class="bi bi-google me-2"></i> Sign in with Google
      </a> --}}

                <hr>
                <p class="mb-0 text-center">
                    <a href="{{ route('register') }}" class="text-primary">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>
@endsection
