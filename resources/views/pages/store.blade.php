@extends('layouts.apps')

@section('title', 'Jukiverse - Store')

@section('content')
    {{-- Menghapus bg-light atau background standar lainnya --}}
    <div class="store-wrapper min-vh-100 pb-5">
        <div class="container py-5">
            {{-- Header Section --}}
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold"
                    style="color: var(--neon-purple); text-shadow: 0 0 15px rgba(138, 43, 226, 0.5);">JUKIVERSE STORE</h1>
                <p class="text-white-50">Top up your credits and dominate the server.</p>
            </div>

            <div class="row">
                {{-- Sidebar Profile --}}
                <div class="col-md-4 mb-4">
                    <div class="card dark-card text-white border-0 shadow-lg profile-card overflow-hidden h-100">
                        <div class="profile-header"
                            style="height: 100px; background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%); opacity: 0.8;">
                        </div>

                        {{-- Tambahkan d-flex dan flex-column di sini --}}
                        <div class="card-body text-center d-flex flex-column" style="margin-top: -50px;">

                            <div class="position-relative d-inline-block mb-3">
                                <img src="https://mc-heads.net/avatar/{{ session('uuid') }}/100" alt="Skin"
                                    class="rounded-circle border border-4 border-dark shadow-lg profile-avatar">
                                <span
                                    class="position-absolute bottom-0 end-0 p-2 bg-success border border-light rounded-circle pulse-online"></span>
                            </div>

                            <h3 class="text-info fw-bold mb-1">{{ session('username') }}</h3>
                            <p class="small text-white-50">Minecraft Citizen</p>

                            {{-- mt-auto akan mendorong form ini ke paling bawah card-body --}}
                            <form action="{{ route('logout') }}" method="POST" class="mt-auto pt-4">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm w-100 rounded-pill transition-all fw-bold">
                                    Logout Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Recent Purchases Table --}}
                <div class="col-md-8 mb-5">
                    <div class="d-flex align-items-center mb-4">
                        <div
                            class="flex-shrink-0 bg-primary bg-opacity-25 rounded-3 p-2 me-3 shadow-sm border border-primary border-opacity-25">
                            <span class="fs-4">🕒</span>
                        </div>
                        <h2 class="h4 mb-0 fw-bold" style="color: var(--neon-purple);">Transaction History</h2>
                    </div>

                    <div
                        class="table-responsive dark-card rounded-4 p-0 border border-secondary border-opacity-50 shadow-sm overflow-hidden">
                        <table class="table table-dark table-hover mb-0 align-middle">
                            <thead class="bg-black bg-opacity-50">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-uppercase small fw-bold text-info">Order ID</th>
                                    <th class="py-3 border-0 text-uppercase small fw-bold text-info">Status</th>
                                    <th class="py-3 border-0 text-uppercase small fw-bold text-info">Price</th>
                                    <th class="pe-4 py-3 border-0 text-uppercase small fw-bold text-info text-end">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPurchases as $purchase)
                                    <tr>
                                        <td class="ps-4 py-3 border-secondary border-opacity-10">
                                            <span
                                                class="font-monospace text-white small">#{{ $purchase->midtrans_order_id }}</span>
                                        </td>
                                        <td class="py-3 border-secondary border-opacity-10">
                                            @if ($purchase->payment_status == 'success')
                                                <span class="badge rounded-pill bg-success text-white px-3">SUCCESS</span>
                                            @else
                                                <span class="badge rounded-pill bg-warning text-dark px-3">PENDING</span>
                                            @endif
                                        </td>
                                        <td class="py-3 border-secondary border-opacity-10">
                                            <span class="text-success fw-bold">Rp
                                                {{ number_format($purchase->amount, 0, ',', '.') }}</span>
                                        </td>
                                        <td
                                            class="pe-4 py-3 border-secondary border-opacity-10 text-end text-white-50 small">
                                            {{ \Carbon\Carbon::parse($purchase->created_at)->format('d M, H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-white-50 opacity-50 italic">
                                            No transaction records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <hr class="border-secondary opacity-25 my-5">

            {{-- Product List Section --}}
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: var(--neon-purple);">SELECT COIN PACKAGE</h2>
                <div class="mx-auto bg-primary mb-4"
                    style="height: 3px; width: 60px; box-shadow: 0 0 10px var(--neon-blue);"></div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-3">
                        <div class="card dark-card text-white h-100 shadow-sm item-card text-center">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="mb-3 mx-auto icon-glow">
                                    <span style="font-size: 3rem;">💰</span>
                                </div>
                                <h5 class="card-title fw-bold text-info mb-3">{{ $product->product_name }}</h5>
                                <p class="card-text text-white-50 small flex-grow-1 px-2">
                                    {{ $product->description ?? 'Get ' . number_format($product->amount) . ' coins for your account instantly.' }}
                                </p>

                                <div
                                    class="bg-black bg-opacity-40 rounded-pill py-2 mb-3 border border-white border-opacity-10">
                                    <h4 class="text-white fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </h4>
                                </div>

                                <form action="{{ route('purchase.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="fixed">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                        class="btn btn-info w-100 py-2 fw-bold rounded-pill shadow-sm purchase-btn text-dark">
                                        BUY NOW
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Custom Amount Card --}}
                <div class="col-md-6 col-lg-3">
                    <div class="card dark-card text-white h-100 shadow-sm item-card text-center border-info border-opacity-50"
                        style="border-style: dashed !important; background: rgba(15, 23, 42, 0.4) !important;">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-3 mx-auto icon-glow">
                                <span style="font-size: 3rem;">✨</span>
                            </div>
                            <h5 class="card-title fw-bold text-info mb-1">Custom Amount</h5>
                            <p class="small text-white-50 mb-3">Min. 100 (Rp 10/Coin)</p>

                            <form action="{{ route('purchase.submit') }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="type" value="custom">
                                <div class="input-group mb-3">
                                    <input type="number" name="amount" id="customInput"
                                        class="form-control bg-black bg-opacity-50 text-white border-secondary text-center rounded-start-pill"
                                        placeholder="Qty" min="100" required>
                                    <span
                                        class="input-group-text bg-secondary border-secondary text-white rounded-end-pill">Qty</span>
                                </div>
                                <div class="d-flex justify-content-between small px-2 mb-3">
                                    <span class="text-white-50">Total:</span>
                                    <span id="customDisplay" class="text-success fw-bold fs-5">Rp 0</span>
                                </div>
                                <button type="submit"
                                    class="btn btn-outline-info w-100 py-2 fw-bold rounded-pill transition-all">PURCHASE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --neon-purple: #bc13fe;
            --neon-blue: #0dcaf0;
        }

        /* FIX: Memaksa Background Radial di Body agar menyatu dengan Dashboard */
        body {
            background-color: #060918 !important;
            background-image: radial-gradient(circle at 50% 50%, #101a33 0%, #060918 100%) !important;
            background-attachment: fixed;
            color: #e2e8f0;
        }

        /* Card bergaya Glassmorphism */
        .dark-card {
            background: rgba(15, 23, 42, 0.7) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 20px;
        }

        .profile-card {
            transition: transform 0.3s ease;
        }

        .item-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .item-card:hover {
            transform: translateY(-12px);
            border-color: var(--neon-blue) !important;
            box-shadow: 0 15px 30px rgba(0, 217, 255, 0.2) !important;
            background: rgba(15, 23, 42, 0.85) !important;
        }

        .icon-glow {
            filter: drop-shadow(0 0 10px rgba(0, 217, 255, 0.3));
        }

        .purchase-btn {
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        .purchase-btn:hover {
            background-color: white !important;
            color: black !important;
            box-shadow: 0 0 15px white;
        }

        .pulse-online {
            box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(25, 135, 84, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(25, 135, 84, 0);
            }
        }

        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.8) !important;
            color: white !important;
            border-color: var(--neon-blue) !important;
            box-shadow: 0 0 10px rgba(0, 217, 255, 0.2);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03) !important;
        }
    </style>

    <script>
        document.getElementById('customInput').addEventListener('input', function() {
            let coins = this.value;
            let price = coins * 10;
            if (coins < 0) price = 0;
            document.getElementById('customDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                price);
        });
    </script>
@endsection
