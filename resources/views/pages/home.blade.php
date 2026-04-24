@extends('layouts.apps')

@section('title', 'Jukiverse - Home')

@section('content')
{{-- Menghapus bg-light agar background body radial terlihat --}}
<div class="dashboard-wrapper min-vh-100 pb-5">
    
    {{-- Hero Section --}}
    <div class="hero-section text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center text-lg-start">
                    {{-- Badge Cyan untuk kontras tinggi --}}
                    <span class="badge bg-info text-dark mb-3 px-3 py-2 rounded-pill fw-bold shadow-glow">HOME</span>
                    <h1 class="display-4 fw-bold mb-2 text-white">
                        Welcome back, <span class="text-info text-shadow-sm">{{ session('username') }}</span>! 👋
                    </h1>
                    <p class="text-white-50 fs-5">Senang melihatmu kembali. Jelajahi koleksi terbaru dan kelola akunmu di sini.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                    <div class="d-inline-flex gap-2 p-2 bg-white bg-opacity-10 rounded-4 backdrop-blur border border-white border-opacity-10">
                        <a href="{{ route('store') }}" class="btn btn-info btn-lg px-4 fw-bold rounded-3 shadow-sm text-dark">
                            <i class="bi bi-shop me-2"></i>Go to Store
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-lg px-4 rounded-3 fw-bold">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-4">
            {{-- Stat Card: Credits --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card dark-card border-0 shadow-lg rounded-4 overflow-hidden h-100 border-top border-4 border-success">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="icon-shape bg-success bg-opacity-20 text-success rounded-3 p-3">
                                <span class="fs-3">💰</span>
                            </div>
                            <span class="text-white-50 small fw-bold text-uppercase tracking-wider">Available Balance</span>
                        </div>
                        <h6 class="text-white-50 small fw-bold mb-1 text-uppercase">Your Credits</h6>
                        <h2 class="display-6 fw-bold mb-0 text-white">
                            {{ number_format($currentCredits ?? 0) }} <small class="fs-6 text-success fw-normal">pts</small>
                        </h2>
                    </div>
                    <div class="card-footer bg-black bg-opacity-20 border-0 pb-4 px-4">
                        <a href="{{ route('store') }}" class="btn btn-link text-success p-0 text-decoration-none fw-bold">Top Up Credits →</a>
                    </div>
                </div>
            </div>

            {{-- Action Card: Store --}}
            <div class="col-12 col-md-6 col-lg-4">
                <a href="{{ route('store') }}" class="card dark-card border-0 shadow-lg rounded-4 h-100 text-decoration-none transition-hover border-top border-4 border-info">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="icon-shape bg-info bg-opacity-20 text-info rounded-3 p-3">
                                <span class="fs-3">🛍️</span>
                            </div>
                        </div>
                        <h3 class="h5 fw-bold text-white">Browse Store</h3>
                        <p class="text-white-50 mb-0 small">Temukan item eksklusif dan update terbaru di Jukiverse Store.</p>
                    </div>
                </a>
            </div>

            {{-- Action Card: Settings/Profile --}}
            <div class="col-12 col-md-6 col-lg-4">
                <a href="{{ route('settings') }}" class="card dark-card border-0 shadow-lg rounded-4 h-100 text-decoration-none transition-hover border-top border-4 border-purple">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="icon-shape bg-purple-soft text-purple rounded-3 p-3">
                                <span class="fs-3">⚙️</span>
                            </div>
                        </div>
                        <h3 class="h5 fw-bold text-white">Account Settings</h3>
                        <p class="text-white-50 mb-0 small">Kelola informasi profil dan keamanan akun Anda dengan mudah.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --purple-main: #a855f7;
        --blue-main: #3b82f6;
        --neon-cyan: #00d9ff;
    }

    /* Memaksa background radial ke seluruh halaman */
    body {
        background-color: #060918 !important;
        background-image: radial-gradient(circle at 50% 50%, #101a33 0%, #060918 100%) !important;
        background-attachment: fixed;
        color: #e2e8f0;
        margin: 0;
    }

    .hero-section {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(147, 51, 234, 0.15) 100%);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0 0 3rem 3rem;
    }

    /* Card bergaya Glassmorphism (Transparan Gelap) */
    .dark-card {
        background: rgba(15, 23, 42, 0.6) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .transition-hover:hover {
        transform: translateY(-10px);
        background: rgba(30, 41, 59, 0.8) !important;
        border-color: rgba(0, 217, 255, 0.4) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5) !important;
    }

    .text-shadow-sm {
        text-shadow: 0 0 15px rgba(0, 217, 255, 0.6);
    }

    .shadow-glow {
        box-shadow: 0 0 20px rgba(0, 217, 255, 0.3);
    }

    .backdrop-blur {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
    }

    .text-purple { color: var(--purple-main); }
    .bg-purple-soft { background-color: rgba(168, 85, 247, 0.2); }
    .border-purple { border-color: var(--purple-main) !important; }
    
    .tracking-wider {
        letter-spacing: 0.1em;
    }

    /* Perbaikan link Top Up agar tidak tenggelam di background gelap */
    .btn-link:hover {
        color: #fff !important;
        text-shadow: 0 0 10px rgba(25, 135, 84, 0.5);
    }
</style>
@endsection