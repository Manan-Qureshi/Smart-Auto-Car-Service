@extends('layouts.app')

@section('content')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">

<div class="auth-container">
    <div class="auth-card">
        <p class="auth-subtitle">Welcome to our service</p>
        <h1 class="auth-title">Create account</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group mb-3">
                <input id="name" type="text" 
                    class="form-control auth-input @error('name') is-invalid @enderror" 
                    name="name" value="{{ old('name') }}" 
                    placeholder="Full name"
                    required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <input id="email" type="email" 
                    class="form-control auth-input @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" 
                    placeholder="Email address"
                    required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <input id="phone_number" type="text" 
                    class="form-control auth-input @error('phone_number') is-invalid @enderror" 
                    name="phone_number" value="{{ old('phone_number') }}" 
                    placeholder="Phone number"
                    required>

                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <textarea id="address" 
                    class="form-control auth-input @error('address') is-invalid @enderror" 
                    name="address" 
                    placeholder="Residential address"
                    style="height: auto; min-height: 80px;"
                    required>{{ old('address') }}</textarea>

                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <input id="password" type="password" 
                    class="form-control auth-input @error('password') is-invalid @enderror" 
                    name="password" 
                    placeholder="Password"
                    required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <input id="password-confirm" type="password" 
                    class="form-control auth-input" 
                    name="password_confirmation" 
                    placeholder="Confirm password"
                    required autocomplete="new-password">
            </div>

            <button type="submit" class="btn-auth-primary">
                Register
            </button>

            <a href="{{ route('google.login') }}" class="btn-auth-google text-decoration-none">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" height="20" alt="Google">
                Sign up with Google
            </a>

            <div class="auth-footer">
                Already have an account? 
                <a href="{{ route('login') }}" class="auth-link">Login</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Add auth-page class to body for specific styles
    document.body.classList.add('auth-page');
</script>
@endsection