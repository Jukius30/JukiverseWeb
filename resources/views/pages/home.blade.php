@extends('layouts.apps')

@section('title', 'Jukiverse - Dashboard')

@section('content')
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-5 shadow-lg">
        <div class="container text-center">
            {{-- Menampilkan Nama User dari Session --}}
            <h1 class="display-4 fw-bold mb-4">Welcome back, {{ session('username') }}!</h1>
            <p class="lead mb-4">Discover amazing content and explore our store at Jukiverse.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('store') }}" class="btn btn-light btn-lg fw-semibold">
                    Go to Store
                </a>
                {{-- Tombol Logout karena ini dashboard --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-lg">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="display-5 fw-bold mb-4">Quick Access</h2>
        <div class="row g-4">
            {{-- Card Store --}}
            <div class="col-12 col-md-6 col-lg-3">
                {{-- Perbaikan: Tanda kutip di style yang tadi kurang --}}
                <a href="{{ route('store') }}"
                    class="card text-center text-decoration-none h-100 shadow-sm border-0 transition-hover"
                    style="color: var(--neon-purple);">
                    <div class="card-body py-4">
                        <div class="fs-1 mb-3">🛍️</div>
                        <h3 class="card-title fs-5 fw-semibold text-dark">Browse Store</h3>
                        <p class="card-text text-muted">Explore our latest products and items</p>
                    </div>
                </a>
            </div>

            {{-- Info Card (Kredit User) --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-center h-100 shadow-sm border-0">
                    <div class="card-body py-4">
                        <div class="fs-1 mb-3">💰</div>
                        <h3 class="card-title fs-5 fw-semibold text-dark">Your Credits</h3>
                        {{-- Variabel dari HomeController --}}
                        <p class="card-text fw-bold fs-4 text-success">{{ number_format($currentCredits ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-gradient-to-r {
            background: linear-gradient(to right, #2563eb, #9333ea);
        }
    </style>
@endsection
