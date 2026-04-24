@extends('layouts.apps')

@section('title', 'Jukiverse - Settings')

@section('content')
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-white mb-1">
                        <i class="bi bi-gear-fill text-info me-2"></i>Account <span class="text-info">Settings</span>
                    </h2>
                    <p class="text-white-50 small text-uppercase tracking-widest">Update Your Information</p>
                </div>

                <div class="card dark-card border-0 shadow-lg overflow-hidden">
                    <div class="card-body p-4 p-lg-5">

                        @if (session('success'))
                            <div
                                class="alert alert-success bg-success bg-opacity-20 text-white border-success border-opacity-50 small mb-4">
                                <i class="bi bi-check-circle-fill me-2 text-info"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('settings.update_email') }}" method="POST">
                            @csrf

                            {{-- Read Only: UUID & Name --}}
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-info text-uppercase">Minecraft Account</label>
                                <input type="text"
                                    class="form-control bg-black bg-opacity-30 text-white-50 border-secondary border-opacity-25"
                                    value="{{ session('username') }}" readonly>
                            </div>

                            {{-- Email Input --}}
                            <div class="mb-4">
                                <label for="email" class="form-label small fw-bold text-info text-uppercase">Email
                                    Address</label>
                                <div class="input-group custom-input-group">
                                    <span class="input-group-text bg-transparent border-end-0 text-info">
                                        <i class="bi bi-envelope-at"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control bg-transparent text-white border-start-0 @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="email@jukiverse.id" {{-- Mengambil data dari variabel $player yang dikirim controller --}}
                                        value="{{ old('email', $player->email_address ?? session('email')) }}" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                                @enderror
                                <div class="form-text small text-white-50 mt-2">
                                    <i class="bi bi-info-circle me-1 text-info"></i> Email ini digunakan untuk sinkronisasi
                                    koin.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info w-100 py-3 fw-bold shadow-glow btn-update">
                                SAVE CHANGES <i class="bi bi-save ms-1"></i>
                            </button>
                        </form>
                    </div>

                    <div class="card-footer bg-black bg-opacity-20 border-0 text-center py-3">
                        {{-- Menggunakan text-info agar biru cerah dan terbaca jelas --}}
                        <a href="{{ route('home') }}" class="text-info small text-decoration-none fw-bold hover-white">
                            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #060918 !important;
            background-image: radial-gradient(circle at 50% 50%, #101a33 0%, #060918 100%) !important;
            background-attachment: fixed;
        }

        .dark-card {
            background: rgba(15, 23, 42, 0.7) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 1.5rem;
        }

        .custom-input-group .input-group-text,
        .custom-input-group .form-control {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .custom-input-group .form-control:focus {
            background: rgba(0, 217, 255, 0.05);
            border-color: #00d9ff;
            box-shadow: 0 0 10px rgba(0, 217, 255, 0.2);
            color: white;
        }

        .btn-update {
            background-color: #00d9ff;
            color: #060918;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            background-color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 217, 255, 0.3);
        }

        .shadow-glow {
            box-shadow: 0 0 15px rgba(0, 217, 255, 0.2);
        }

        .hover-white:hover {
            color: white !important;
        }
    </style>
@endsection
