@extends('layouts.apps')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-info shadow">
                <div class="card-header border-secondary text-center">
                    <h4>Ringkasan Pembelian</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Produk:</span>
                        <span class="fw-bold">{{ $productName }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Jumlah Koin:</span>
                        <span class="fw-bold text-info">{{ number_format($amount) }} Coins</span>
                    </div>
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5">Total Bayar:</span>
                        <span class="fs-5 fw-bold text-success">Rp {{ number_format($price) }}</span>
                    </div>

                    <form action="{{ route('purchase.pay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="hidden" name="price" value="{{ $price }}">
                        <input type="hidden" name="product_id" value="{{ $productId }}">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">BAYAR SEKARANG (MIDTRANS)</button>
                    </form>
                    <a href="{{ route('store') }}" class="btn btn-link w-100 mt-2 text-muted">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection