@extends('layouts.apps')

@section('title', 'Jukiverse - Store')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- Sidebar Profile --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white border-info shadow">
                    <div class="card-body text-center">
                        <img src="https://mc-heads.net/avatar/{{ session('uuid') }}/100" alt="Skin"
                            class="mb-3 rounded shadow">
                        <h3 class="text-info">{{ session('username') }}</h3>
                        <hr class="border-secondary">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm w-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Recent Purchases Table --}}
            <div class="col-md-8 mb-5">
                <h2 class="mb-4" style="color: var(--neon-purple);">Recent Purchases</h2>
                <div class="table-responsive bg-dark rounded p-3 border border-secondary">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPurchases as $purchase)
                                <tr>
                                    {{-- Menampilkan Order ID karena kolom product_name tidak ada di transactions --}}
                                    <td class="small text-info">{{ $purchase->midtrans_order_id }}</td>
                                    <td>
                                        @if ($purchase->payment_status == 'success')
                                            <span class="badge bg-success">SUCCESS</span>
                                        @else
                                            <span class="badge bg-warning text-dark">PENDING</span>
                                        @endif
                                    </td>
                                    {{-- Gunakan 'amount' sesuai nama kolom di database --}}
                                    <td class="text-success fw-bold">Rp {{ number_format($purchase->amount, 0, ',', '.') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($purchase->created_at)->format('d M H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No purchases found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-5">

        {{-- Product List Section --}}
        <h2 class="mb-4 text-center" style="color: var(--neon-purple);">Buy Coins</h2>
        <div class="row g-4">
            {{-- 1. Loop Fixed Products dari Database --}}
            @foreach ($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card bg-dark text-white border-secondary h-100 shadow-sm item-card text-center">
                        <div class="card-body d-flex flex-column">
                            <div class="fs-1 mb-2">💰</div>
                            <h5 class="card-title text-info">{{ $product->product_name }} Coins</h5>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ $product->description ?? 'Get ' . number_format($product->amount) . ' coins instantly.' }}
                            </p>
                            <div class="mt-3">
                                <h4 class="text-success mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                                <form action="{{ route('purchase.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="fixed">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-primary w-100 fw-bold">Buy Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- 2. Card Custom Amount (Hardcoded) --}}
            <div class="col-md-4 col-lg-3">
                <div class="card bg-dark text-white border-info h-100 shadow-sm item-card text-center"
                    style="border-style: dashed;">
                    <div class="card-body d-flex flex-column">
                        <div class="fs-1 mb-2">✨</div>
                        <h5 class="card-title text-info">Custom Amount</h5>
                        <p class="card-text text-muted small">Min. 100 Coins (Rp 10/coin)</p>

                        <form action="{{ route('purchase.submit') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="type" value="custom">
                            <div class="input-group mb-2">
                                <input type="number" name="amount" id="customInput"
                                    class="form-control bg-dark text-white border-info" placeholder="Qty..." min="100"
                                    required>
                            </div>
                            <p class="small text-success mb-3">Total: <span id="customDisplay">Rp 0</span></p>
                            <button type="submit" class="btn btn-outline-info w-100 fw-bold">Purchase</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .item-card {
            transition: all 0.3s ease;
        }

        .item-card:hover {
            transform: translateY(-10px);
            border-color: #0dcaf0 !important;
            box-shadow: 0 10px 20px rgba(13, 202, 240, 0.2) !important;
        }
    </style>

    <script>
        // Logika perhitungan harga custom Rp 10 per koin
        document.getElementById('customInput').addEventListener('input', function() {
            let coins = this.value;
            let price = coins * 10;
            if (coins < 0) price = 0;
            document.getElementById('customDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                price);
        });
    </script>
@endsection
