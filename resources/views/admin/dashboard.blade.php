@extends('layouts.apps')

@section('title', 'Admin Dashboard - Jukiverse')

@section('content')
    <div class="container-fluid py-4 px-3 px-md-5">
        
        <!-- Topbar / Header Section -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-5 border-bottom border-secondary pb-4">
            <div>
                <h1 class="text-white fw-black mb-1 tracking-wide" style="font-size: 2rem;">ADMIN DASHBOARD</h1>
                <p class="text-secondary small mb-0">
                    <span class="opacity-75">Welcome back,</span> <strong class="text-info">{{ session('admin_name') }}</strong>
                </p>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-danger px-3 py-2 fw-semibold" style="border-radius: 6px; font-size: 0.85rem;">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout Admin
                </button>
            </form>
        </div>

        <!-- Search Section -->
        <div class="row mb-4">
            <div class="col-12 col-md-6 col-lg-5">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-info text-secondary"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-dark text-white border-info custom-search-input"
                            placeholder="Cari Order ID atau Nama Player..." value="{{ $search ?? '' }}" style="border-radius: 0 6px 6px 0;">
                    </div>
                    <button type="submit" class="btn btn-info fw-bold px-4" style="border-radius: 6px;">Search</button>
                    @if ($search)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" style="border-radius: 6px;">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Search Alert Notification -->
        @if ($search)
            <div class="alert alert-info bg-dark border-info text-white mb-4 d-flex align-items-center gap-2 small" style="border-radius: 8px;">
                <i class="bi bi-info-circle-fill text-info"></i>
                <div>Menampilkan hasil pencarian untuk: <strong class="text-info">"{{ $search }}"</strong></div>
            </div>
        @endif
        
        <!-- Main Tables Section -->
        <div class="row g-4">
            
            {{-- Tabel Transaksi --}}
            <div class="col-12 mb-2">
                <div class="card bg-dark border-secondary shadow-lg custom-card">
                    <div class="card-header bg-dark border-secondary py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 4px; height: 18px; background: #0dcaf0; border-radius: 2px;"></div>
                            <h5 class="mb-0 text-info fw-bold text-uppercase small tracking-wide" style="letter-spacing: 0.5px;">All Transactions</h5>
                        </div>
                        <span class="badge bg-info text-dark fw-bold px-2.5 py-1.5" style="font-size: 0.75rem;">{{ count($transactions) }} TOTAL</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle mb-0">
                                <thead class="custom-thead text-secondary small text-uppercase">
                                    <tr>
                                        <th class="ps-4 py-3">Order ID</th>
                                        <th class="py-3">Player Name</th>
                                        <th class="py-3">Email</th>
                                        <th class="py-3">Amount</th>
                                        <th class="py-3">Status</th>
                                        <th class="pe-4 py-3 text-end">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $t)
                                        <tr>
                                            <td class="ps-4 small text-info font-monospace">{{ $t->midtrans_order_id }}</td>
                                            <td>
                                                <div class="fw-bold text-white">{{ $t->minecraft_name ?? 'Unknown' }}</div>
                                                <div class="text-secondary font-monospace" style="font-size: 0.7rem; opacity: 0.6;">{{ $t->minecraft_uuid }}</div>
                                            </td> 
                                            <td class="text-light opacity-75 small">{{ $t->email_address ?? '-' }}</td>
                                            <td class="text-success fw-bold">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($t->payment_status == 'success')
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">SUCCESS</span>
                                                @else
                                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-2 py-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">{{ strtoupper($t->payment_status) }}</span>
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end small text-secondary">{{ $t->created_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-secondary">
                                                <div class="mb-2" style="font-size: 1.5rem;"><i class="bi bi-wallet2"></i></div>
                                                <div class="small">No Transactions Found.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Provision Logs --}}
            <div class="col-12">
                <div class="card bg-dark border-secondary shadow-lg custom-card">
                    <div class="card-header bg-dark border-secondary py-3">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 4px; height: 18px; background: #ffc107; border-radius: 2px;"></div>
                            <h5 class="mb-0 text-warning fw-bold text-uppercase small tracking-wide" style="letter-spacing: 0.5px;">Provisioning Logs (Minecraft Delivery)</h5>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle mb-0">
                                <thead class="custom-thead text-secondary small text-uppercase">
                                    <tr>
                                        <th class="ps-4 py-3">Order ID</th>
                                        <th class="py-3">Player Name</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Message Log</th>
                                        <th class="py-3">Time</th>
                                        <th class="pe-4 py-3 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($provisionLogs as $log)
                                        <tr class="{{ $log->execution_status != 'success' ? 'table-danger-custom' : '' }}">
                                            <td class="ps-4 small font-monospace text-secondary opacity-75">{{ $log->midtrans_order_id }}</td>
                                            <td class="fw-bold text-white">{{ $log->minecraft_name ?? 'Unknown' }}</td>
                                            <td>
                                                <span class="badge {{ $log->execution_status == 'success' ? 'bg-success bg-opacity-10 text-success border border-success' : 'bg-danger bg-opacity-10 text-danger border border-danger' }} px-2 py-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                                    {{ strtoupper($log->execution_status) }}
                                                </span>
                                            </td>
                                            <td class="small text-light opacity-75" style="max-width: 320px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $log->message_log }}
                                            </td>
                                            <td class="small text-secondary">{{ $log->executed_at }}</td>
                                            <td class="pe-4 text-end">
                                                @if ($log->execution_status != 'success')
                                                    <form action="{{ route('admin.provision.retry', $log->id) }}" method="POST" onsubmit="return confirm('Kirim ulang koin ke {{ $log->minecraft_name }}?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning fw-bold px-3 py-1 text-dark shadow-sm hover-scale" style="border-radius: 4px; font-size: 0.75rem;">
                                                            Retry
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-secondary small pe-2">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-secondary">
                                                <div class="mb-2" style="font-size: 1.5rem;"><i class="bi bi-terminal"></i></div>
                                                <div class="small">No Provision Logs Available.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Layout Tweaks & Custom Dark Styling -->
    <style>
        .fw-black { font-weight: 900; }
        .tracking-wide { letter-spacing: 0.5px; }
        
        .custom-card {
            border-radius: 12px;
            overflow: hidden;
        }

        .custom-thead {
            background-color: #17191c !important;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .table th {
            border-bottom: 1px solid #2d3238 !important;
        }

        .table td {
            padding-top: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid #23272b;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        .custom-search-input:focus {
            box-shadow: 0 0 0 3px rgba(13, 202, 240, 0.15);
        }

        /* Redesign baris error agar menyatu dengan dark-mode dan tidak menutupi font */
        .table-danger-custom {
            background-color: rgba(220, 53, 69, 0.04) !important;
        }
        .table-danger-custom td {
            border-bottom: 1px solid rgba(220, 53, 69, 0.15) !important;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            transition: transform 0.15s ease-in-out;
        }
    </style>
@endsection