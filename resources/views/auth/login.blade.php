@extends('layouts.app')

@section('content')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">

<div class="auth-container">
    <div class="auth-card">
        <p class="auth-subtitle">Please enter your details</p>
        <h1 class="auth-title">Welcome back</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group mb-3">
                <input id="email" type="email" 
                    class="form-control auth-input @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" 
                    placeholder="Email address"
                    required autocomplete="email" autofocus>

                @error('email')
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
                    required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-options">
                <label class="auth-checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Remember for 30 days</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        Forgot password
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-auth-primary">
                Login
            </button>

            <a href="{{ route('google.login') }}" class="btn-auth-google text-decoration-none">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" height="20" alt="Google">
                Sign in with Google
            </a>

            <div class="auth-footer">
                Don't have an account? 
                <a href="{{ route('register') }}" class="auth-link">Sign up</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Add auth-page class to body for specific styles
    document.body.classList.add('auth-page');
</script>
@endsection