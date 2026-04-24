@extends('layouts.apps')

@section('title', 'Confirm Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            {{-- Stepper Sederhana --}}
            <div class="d-flex justify-content-center mb-4 text-muted small fw-bold">
                <span class="text-primary">1. Pilih Produk</span>
                <span class="mx-2">/</span>
                <span class="text-primary">2. Konfirmasi</span>
                <span class="mx-2">/</span>
                <span>3. Bayar</span>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- Header dengan Gradient --}}
                <div class="card-header bg-gradient-dark py-4 text-center border-0">
                    <h4 class="mb-0 fw-bold text-white">Konfirmasi Pembayaran</h4>
                    <p class="text-white-50 small mb-0">Silakan periksa detail pesanan Anda</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    {{-- Item Info --}}
                    <div class="text-center mb-4">
                        <div class="display-5 mb-2">💎</div>
                        <h5 class="fw-bold mb-1">{{ number_format($amount) }} Koin</h5>
                        <span class="badge bg-info-soft text-info px-3 py-2 rounded-pill">
                            {{ number_format($amount) }} Koin Jukiverse
                        </span>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Metode Pembayaran</span>
                            <span class="fw-semibold">Midtrans</span>
                        </div>
                        <div class="d-flex justify-content-between mb-0">
                            <span class="text-muted">ID Produk</span>
                            <span class="fw-semibold text-uppercase">#{{ $productId }}</span>
                        </div>
                    </div>

                    <hr class="dashed my-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="d-block text-muted small">Total yang harus dibayar:</span>
                            <h3 class="fw-bold text-primary mb-0">Rp {{ number_format($price, 0, ',', '.') }}</h3>
                        </div>
                        <div class="text-end">
                            <i class="bi bi-shield-check text-success fs-2"></i>
                        </div>
                    </div>

                    <form action="{{ route('purchase.pay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="hidden" name="price" value="{{ $price }}">
                        <input type="hidden" name="product_id" value="{{ $productId }}">
                        
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm btn-pay">
                            BAYAR SEKARANG
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('store') }}" class="text-decoration-none text-muted small hover-danger">
                            <i class="bi bi-arrow-left me-1"></i> Batalkan Pesanan
                        </a>
                    </div>
                </div>

                <div class="card-footer bg-light border-0 py-3 text-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Midtrans.png" alt="Midtrans Logo" height="20" class="opacity-50 grayscale">
                </div>
            </div>
            
            <p class="text-center text-muted small mt-4">
                <i class="bi bi-lock-fill me-1"></i> Transaksi terenkripsi dan aman.
            </p>
        </div>
    </div>
</div>

<style>
    .bg-gradient-dark {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    }

    .bg-info-soft {
        background-color: rgba(13, 202, 240, 0.1);
    }

    .dashed {
        border: none;
        border-top: 2px dashed #dee2e6;
    }

    .btn-pay {
        letter-spacing: 1px;
        transition: transform 0.2s;
    }

    .btn-pay:hover {
        transform: translateY(-2px);
        background-color: #0d6efd;
    }

    .grayscale {
        filter: grayscale(100%);
    }

    .hover-danger:hover {
        color: #dc3545 !important;
    }

    .rounded-4 { border-radius: 1.2rem !important; }
</style>
@endsection