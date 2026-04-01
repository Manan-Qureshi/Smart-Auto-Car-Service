@extends('layouts.app')
@section('content')
<div class="container py-5" style="max-width:600px">
    <div class="glass-card p-5 rounded-4 text-center shadow">
        <div class="mb-4" style="font-size:4rem">⏳</div>
        <h3 class="fw-bold mb-2">Account Pending Setup</h3>
        <p class="text-muted mb-4">
            Your provider account is registered but the admin hasn't configured your service provider profile yet.
            Once the admin sets up your business profile (name, address, location), you'll be able to manage bookings, workers, and services.
        </p>
        <div class="alert alert-info rounded-3 text-start">
            <i class="fas fa-info-circle me-2"></i>
            <strong>What the admin needs to do:</strong> Go to <em>Admin → Service Providers → Add Provider</em> and link your email <strong>{{ auth()->user()->email }}</strong> as the owner.
        </div>
        <a href="{{ route('welcome') }}" class="btn btn-outline-primary rounded-pill mt-2">
            <i class="fas fa-home me-2"></i> Back to Home
        </a>
    </div>
</div>
@endsection
