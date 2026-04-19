@extends('layouts.apps')

@section('title', 'Jukiverse - Login')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="card bg-dark text-white shadow-lg border-0" style="background: rgba(10, 14, 39, 0.8) !important; backdrop-filter: blur(10px);">
                <div class="card-header text-center border-0 pt-4">
                    <h3 style="color: var(--neon-cyan); text-shadow: 0 0 10px var(--neon-cyan);">LOGIN KE STORE</h3>
                </div>
                
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger bg-danger text-white border-0 small mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="name" class="form-label small text-uppercase" style="color: var(--neon-purple);">Minecraft Name</label>
                            <input 
                                type="text" 
                                class="form-control bg-transparent text-white border-secondary @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                placeholder="Contoh: JukianaAzura"
                                value="{{ old('name') }}"
                                required
                            >
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email" class="form-label small text-uppercase" style="color: var(--neon-purple);">Email Address</label>
                            <input 
                                type="email" 
                                class="form-control bg-transparent text-white border-secondary @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                placeholder="email@example.com"
                                value="{{ old('email') }}"
                                required
                            >
                            <div class="form-text small text-white">Email ini digunakan untuk menarik riwayat pembelian kamu.</div>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-cyan w-100 py-2 fw-bold shadow-sm">
                            CONNECT ACCOUNT
                        </button>
                    </form>
                </div>

                <div class="card-footer border-0 text-center pb-4">
                    <p class="small text-muted mb-0">Belum pernah main? Join server di:</p>
                    <code style="color: var(--neon-cyan);">play.jukiverse.id</code>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahan style agar input transparan terlihat bagus */
    .form-control:focus, .form-select:focus {
        background-color: rgba(255,255,255,0.05);
        border-color: var(--neon-cyan);
        box-shadow: 0 0 8px rgba(0, 217, 255, 0.4);
        color: white;
    }
    .btn-cyan {
        background-color: var(--neon-cyan);
        color: var(--space-dark);
        border: none;
        transition: 0.3s;
    }
    .btn-cyan:hover {
        background-color: #fff;
        box-shadow: 0 0 15px var(--neon-cyan);
        transform: translateY(-2px);
    }
</style>
@endsection