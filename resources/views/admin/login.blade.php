@extends('layouts.apps')

@section('title', 'Admin Login - Jukiverse')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card bg-dark text-white border-info shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color: var(--neon-purple);">Admin Access</h2>
                <p class="text-muted">Enter credentials to manage Jukiverse</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger bg-danger text-white border-0">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control bg-dark text-white border-secondary" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                </div>
                <button type="submit" class="btn btn-info w-100 fw-bold py-2">Login to Dashboard</button>
            </form>
        </div>
    </div>
</div>
@endsection