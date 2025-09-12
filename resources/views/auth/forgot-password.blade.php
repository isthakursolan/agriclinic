@extends('auth.app')

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center"><b>Agri Clinic</b> - Reset Password</div>
        <div class="card-body">
            <p class="login-box-msg">Enter your email, username or contact to reset password</p>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="login" class="form-control" placeholder="Email / Username / Contact" required>
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">Back to Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
