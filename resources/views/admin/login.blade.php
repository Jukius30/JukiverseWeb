@extends('layouts.apps')

@section('title', 'Admin Login - Jukiverse')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="card bg-dark text-white border-info shadow-lg" style="width: 100%; max-width: 410px; border-radius: 12px; border-width: 2px;">
        <div class="card-body p-4 p-md-5">
            
            <!-- Header: Teks dibuat lebih proporsional -->
            <div class="text-center mb-4">
                <h2 class="fw-black mb-1" style="color: var(--neon-purple); letter-spacing: 1px; font-size: 1.75rem;">ADMIN ACCESS</h2>
                <div style="width: 40px; height: 3px; background: var(--neon-purple); margin: 10px auto 12px; border-radius: 2px;"></div>
                <p class="text-secondary small mb-0">Enter credentials to manage Jukiverse</p>
            </div>

            <!-- Error Notification: Dibuat border-only agar menyatu dengan tema dark -->
            @if(session('error'))
                <div class="alert alert-danger bg-transparent border-danger text-danger border-2 rounded-3 mb-4 py-2.5 small d-flex align-items-center gap-2">
                    <span class="fw-bold">➔</span> {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                
                <!-- Username -->
                <div class="mb-3.5">
                    <label class="form-label text-secondary small fw-bold text-uppercase mb-2" style="letter-spacing: 0.5px;">Username</label>
                    <input type="text" name="username" class="form-control custom-input bg-dark text-white border-secondary" required autofocus style="border-radius: 6px; padding: 10px 14px;">
                </div>
                
                <!-- Password -->
                <div class="mb-4.5" style="margin-bottom: 1.8rem;">
                    <label class="form-label text-secondary small fw-bold text-uppercase mb-2" style="letter-spacing: 0.5px;">Password</label>
                    <input type="password" name="password" class="form-control custom-input bg-dark text-white border-secondary" required style="border-radius: 6px; padding: 10px 14px;">
                </div>

                <!-- Button: Ditambahkan efek transisi standar -->
                <button type="submit" class="btn btn-info w-100 fw-bold text-uppercase py-2.5 shadow-sm custom-btn" style="border-radius: 6px; letter-spacing: 0.5px; transition: all 0.2s ease-in-out;">
                    Login to Dashboard
                </button>
            </form>
            
        </div>
    </div>
</div>

<!-- Style khusus untuk mempercantik input form bawaan Bootstrap -->
<style>
    .custom-input:focus {
        background-color: #151719 !important; /* Sedikit lebih gelap saat fokus */
        border-color: #0dcaf0 !important; /* Tetap pakai warna info */
        box-shadow: 0 0 0 3px rgba(13, 202, 240, 0.15);
        outline: none;
    }
    .custom-btn:hover {
        background-color: #0baccb !important; /* Warna info yang sedikit diredupkan saat di-hover */
        border-color: #0baccb !important;
        transform: translateY(-1px);
    }
    .custom-btn:active {
        transform: translateY(0);
    }
</style>
@endsection