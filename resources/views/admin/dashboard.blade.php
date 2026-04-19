@extends('layouts.apps')

@section('title', 'Admin Dashboard - Jukiverse')

@section('content')
    <div class="container-fluid py-5 px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="text-white fw-bold mb-0">Admin Dashboard</h1>
                <p class="text-muted">Welcome back, {{ session('admin_name') }}</p>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger">Logout Admin</button>
            </form>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control bg-dark text-white border-info"
                        placeholder="Cari Order ID (Contoh: JKV-177...)" value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-info fw-bold">Search</button>
                    @if ($search)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        @if ($search)
            <div class="alert alert-info bg-dark border-info text-white mb-4">
                Menampilkan hasil pencarian untuk: <strong>{{ $search }}</strong>
            </div>
        @endif
        
        <div class="row">
            {{-- Tabel Transaksi --}}
            <div class="col-lg-12 mb-5">
                <div class="card bg-dark border-secondary shadow">
                    <div class="card-header bg-dark border-secondary d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-info">All Transactions</h5>
                        <span class="badge bg-info text-dark">{{ count($transactions) }} Total</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead class="table-secondary text-dark">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Player</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $t)
                                        <tr>
                                            <td class="small">{{ $t->midtrans_order_id }}</td>
                                            <td class="fw-bold">{{ $t->minecraft_name }}</td>
                                            <td class="fw-bold">{{ $t->email_address ?? '-' }}</td>
                                            <td class="text-success">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($t->payment_status == 'success')
                                                    <span class="badge bg-success">SUCCESS</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning text-dark">{{ strtoupper($t->payment_status) }}</span>
                                                @endif
                                            </td>
                                            <td class="small">{{ $t->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Provision Logs --}}
            <div class="col-lg-12">
                <div class="card bg-dark border-secondary shadow">
                    <div class="card-header bg-dark border-secondary">
                        <h5 class="mb-0 text-warning">Provisioning Logs (Minecraft Delivery)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Player</th>
                                        <th>Status</th>
                                        <th>Message Log</th>
                                        <th>Time</th>
                                        <th>Action</th> {{-- Tambah kolom Action --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($provisionLogs as $log)
                                        <tr
                                            class="{{ $log->execution_status != 'success' ? 'table-danger text-dark' : '' }}">
                                            <td>{{ $log->midtrans_order_id }}</td>
                                            <td>{{ $log->minecraft_name }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $log->execution_status == 'success' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ strtoupper($log->execution_status) }}
                                                </span>
                                            </td>
                                            <td class="small">{{ $log->message_log }}</td>
                                            <td class="small">{{ $log->executed_at }}</td>
                                            <td>
                                                {{-- Tombol muncul hanya jika status GAGAL --}}
                                                @if ($log->execution_status != 'success')
                                                    <form action="{{ route('admin.provision.retry', $log->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-warning fw-bold">Retry</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }
    </style>
@endsection
