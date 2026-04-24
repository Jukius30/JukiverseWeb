@extends('layouts.apps')

@section('title', 'Jukiverse - Connect Account')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5 col-lg-4">
            
            {{-- Logo atau Icon Branding --}}
            <div class="text-center mb-4">
                <div class="login-icon-box mb-3 shadow-glow">
                    <i class="bi bi-cpu text-info display-4"></i>
                </div>
                <h2 class="fw-bold text-white mb-1">Jukiverse <span class="text-info">Store</span></h2>
                {{-- Mengganti text-muted menjadi text-white-50 agar lebih terbaca --}}
                <p class="text-white-50 small text-uppercase tracking-widest">Secure Connection Portal</p>
            </div>

            <div class="card login-card border-0 shadow-lg overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    
                    <div class="mb-4">
                        <h4 class="fw-bold text-white mb-2">Welcome, Citizen!</h4>
                        {{-- Mengganti text-muted menjadi text-white-50 --}}
                        <p class="text-white-50 small">Hubungkan akun Minecraft kamu untuk mulai berbelanja.</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger bg-danger bg-opacity-20 text-white border-danger border-opacity-50 small mb-4 py-2">
                            <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        
                        {{-- Minecraft Name Input --}}
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-bold text-info text-uppercase">Minecraft Name</label>
                            <div class="input-group custom-input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-info">
                                    <i class="bi bi-person-badge"></i>
                                </span>
                                <input 
                                    type="text" 
                                    class="form-control bg-transparent text-white border-start-0 @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    placeholder="Username Anda"
                                    value="{{ old('name') }}"
                                    required
                                >
                                @error('name')
                                    <span class="invalid-feedback fw-bold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email Input --}}
                        <div class="mb-4">
                            <label for="email" class="form-label small fw-bold text-info text-uppercase">Email Address</label>
                            <div class="input-group custom-input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-info">
                                    <i class="bi bi-envelope-at"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control bg-transparent text-white border-start-0 @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    placeholder="email@gmail.com"
                                    value="{{ old('email') }}"
                                    required
                                >
                                @error('email')
                                    <span class="invalid-feedback fw-bold">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-text small text-white-50 mt-2">
                                <i class="bi bi-info-circle me-1 text-info"></i> Digunakan untuk sinkronisasi riwayat koin.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info w-100 py-3 fw-bold shadow-glow btn-connect text-uppercase">
                            CONNECT ACCOUNT <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </form>
                </div>

                <div class="card-footer bg-white bg-opacity-10 border-0 text-center py-3">
                    <p class="small text-white-50 mb-0">Server IP: <code class="text-info fw-bold bg-dark px-2 py-1 rounded">play.jukiverse.id</code></p>
                </div>
            </div>
            
            <p class="text-center mt-4 small text-white-50 opacity-75">
                &copy; {{ date('Y') }} Jukiverse Project. All Rights Reserved.
            </p>
        </div>
    </div>
</div>

<style>
    :root {
        --neon-cyan: #00d9ff;
    }

    /* Memastikan background body gelap agar elemen login terlihat kontras */
    body {
        background-color: #060918 !important;
        background-image: radial-gradient(circle at 50% 50%, #101a33 0%, #060918 100%);
    }

    .login-card {
        background: rgba(15, 23, 42, 0.85) !important; /* Dipertebal sedikit */
        backdrop-filter: blur(20px);
        border: 1px solid rgba(0, 217, 255, 0.2) !important;
        border-radius: 1.5rem;
    }

    .login-icon-box {
        width: 80px;
        height: 80px;
        background: rgba(0, 217, 255, 0.1);
        border: 2px solid var(--neon-cyan);
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .custom-input-group .input-group-text {
        border-color: rgba(255, 255, 255, 0.2);
    }

    .custom-input-group .form-control {
        border-color: rgba(255, 255, 255, 0.2);
        font-size: 0.95rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .custom-input-group .form-control::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    .custom-input-group .form-control:focus {
        background: rgba(0, 217, 255, 0.05);
        border-color: var(--neon-cyan);
        box-shadow: 0 0 10px rgba(0, 217, 255, 0.1);
        color: white;
    }

    .btn-connect {
        background-color: var(--neon-cyan);
        color: #060918 !important; /* Memastikan teks tombol tetap hitam pekat */
        border: none;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .btn-connect:hover {
        background-color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 217, 255, 0.4);
    }

    .shadow-glow {
        box-shadow: 0 0 20px rgba(0, 217, 255, 0.25);
    }

    .tracking-widest {
        letter-spacing: 0.2em;
    }

    /* Memperjelas pesan error input */
    .invalid-feedback {
        color: #ff4d4d;
        font-size: 0.8rem;
    }
</style>
@endsection