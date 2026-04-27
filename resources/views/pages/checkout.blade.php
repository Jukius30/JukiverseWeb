@extends('layouts.apps')

@section('title', 'Confirm Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card dark-card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Header dengan Gradient --}}
                <div class="card-header bg-black bg-opacity-50 py-4 text-center border-0">
                    <h4 class="mb-0 fw-bold text-white text-uppercase tracking-wide">Konfirmasi Pesanan</h4>
                    <p class="text-white-50 small mb-0">Silakan periksa detail pesanan Anda</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    {{-- Item Info --}}
                    <div class="text-center mb-4">
                        <div class="display-4 mb-2 icon-glow">💰</div>
                        <h2 class="fw-bold text-white mb-1">{{ number_format($amount) }} Koin</h2>
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill border border-info border-opacity-25">
                            Paket {{ number_format($amount) }} Koin Jukiverse
                        </span>
                    </div>

                    {{-- Kotak Detail (Dulu Putih, Sekarang Glass) --}}
                    <div class="bg-black bg-opacity-40 p-4 rounded-4 mb-4 border border-white border-opacity-10">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50 small">Metode Pembayaran</span>
                            <span class="fw-bold text-white">Midtrans Secure</span>
                        </div>
                        <div class="d-flex justify-content-between mb-0">
                            <span class="text-white-50 small">ID Produk</span>
                            <span class="fw-bold text-info text-uppercase font-monospace">#{{ $productId }}</span>
                        </div>
                    </div>

                    <hr class="dashed opacity-25 my-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="d-block text-white-50 small">Total Pembayaran:</span>
                            <h3 class="fw-bold text-success mb-0" style="text-shadow: 0 0 10px rgba(25, 135, 84, 0.3);">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="text-end">
                            <i class="bi bi-shield-lock-fill text-info fs-1 opacity-75"></i>
                        </div>
                    </div>

                    <form action="{{ route('purchase.pay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="hidden" name="price" value="{{ $price }}">
                        <input type="hidden" name="product_id" value="{{ $productId }}">
                        
                        <button type="submit" class="btn btn-info w-100 py-3 fw-bold rounded-pill shadow-glow btn-pay">
                            LANJUT KE PEMBAYARAN <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('store') }}" class="text-decoration-none text-white-50 small hover-white transition-all">
                            <i class="bi bi-x-circle me-1"></i> Batalkan & Kembali
                        </a>
                    </div>
                </div>

                <div class="card-footer bg-black bg-opacity-30 border-0 py-3 text-center">
                    <img src="{{ asset('assets/midtrans.png') }}" alt="Midtrans Logo" height="20" class="midtrans-logo">
                </div>
            </div>
            
            <p class="text-center text-white-50 small mt-4 opacity-75">
                <i class="bi bi-lock-fill me-1 text-info"></i> Transaksi Anda dilindungi oleh enkripsi SSL.
            </p>
        </div>
    </div>
</div>

<style>
    /* Body sudah radial gradient dari layout utama */

    .dark-card {
        background: rgba(15, 23, 42, 0.8) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    .icon-glow {
        filter: drop-shadow(0 0 15px rgba(0, 217, 255, 0.3));
    }

    .dashed {
        border: none;
        border-top: 2px dashed rgba(255, 255, 255, 0.1);
    }

    .btn-pay {
        background-color: #00d9ff;
        color: #060918;
        border: none;
        letter-spacing: 1px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-pay:hover {
        background-color: #ffffff;
        color: #000000;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 217, 255, 0.4);
    }

    .midtrans-logo {
        filter: brightness(0) invert(1) opacity(0.5);
    }

    .hover-white:hover {
        color: #ffffff !important;
    }

    .tracking-wider { letter-spacing: 2px; }
    .shadow-glow { box-shadow: 0 0 15px rgba(0, 217, 255, 0.2); }
    .transition-all { transition: all 0.3s ease; }
</style>
@endsection