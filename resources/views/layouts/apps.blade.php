<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jukiverse')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --space-dark: #060918;
            --space-darker: #03050c;
            --space-blue: #1e3a8a;
            --neon-cyan: #00d9ff;
            --neon-purple: #c084fc;
            --glass-white: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--space-darker);
            background-image: 
                radial-gradient(at 0% 0%, rgba(30, 58, 138, 0.2) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(106, 45, 92, 0.2) 0px, transparent 50%);
            /* FIX 1: Warna teks utama diubah ke putih terang */
            color: #ffffff; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            /* FIX 2: Perataan font agar lebih tajam */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* FIX 3: Pastikan semua paragraf & teks muted tetap terbaca */
        p, .text-muted {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        .fw-bold { color: #ffffff; }

        /* Modern Navbar Customization */
        .navbar {
            background: rgba(6, 9, 24, 0.85) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
            padding: 0.8rem 0;
            transition: all 0.3s ease;
        }

        .nav-link {
            /* FIX 4: Warna nav-link lebih terang */
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--neon-cyan) !important;
        }

        /* Content Area */
        main {
            padding-top: 20px;
        }

        /* Footer Redesign */
        footer {
            background: var(--space-dark);
            border-top: 1px solid var(--glass-border);
        }

        .footer-link {
            /* FIX 5: Warna link footer lebih terang */
            color: rgba(255, 255, 255, 0.7) !important;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .footer-link:hover {
            color: var(--neon-cyan) !important;
            transform: translateX(5px);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--space-darker); }
        ::-webkit-scrollbar-thumb { 
            background: #334155; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--neon-purple); }
    </style>
</head>
<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="{{ asset('assets/logo.png') }}" alt="Jukiverse" height="42">
                </a>
                
                <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center gap-2">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/store">Store</a></li>
                        <li class="nav-item ms-lg-3">
                            @if(session('username'))
                                <div class="d-flex align-items-center gap-3 bg-white bg-opacity-10 px-3 py-2 rounded-pill border border-white border-opacity-20 shadow-sm">
                                    <small class="fw-bold text-info"><i class="bi bi-person-circle me-1"></i> {{ session('username') }}</small>
                                </div>
                            @else
                                <a href="/login" class="btn btn-sm btn-info px-4 rounded-pill fw-bold shadow-glow">Login</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="min-vh-100">
        @yield('content')
    </main>

    <footer class="pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" height="40" class="mb-3">
                    <p>
                        Jukiverse menyediakan ekosistem gaming terbaik dengan sistem pembayaran yang aman dan koin yang bisa langsung digunakan di dunia virtual kami.
                    </p>
                </div>
                
                <div class="col-md-4 col-lg-2">
                    <h6 class="text-white fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="/" class="footer-link">Dashboard</a></li>
                        <li><a href="/store" class="footer-link">Store</a></li>
                        <li><a href="#" class="footer-link">Terms of Service</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-3">
                    <h6 class="text-white fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Help Center</a></li>
                        <li><a href="#" class="footer-link">Contact Admin</a></li>
                        <li><a href="#" class="footer-link">Report a Bug</a></li>
                    </ul>
                </div>
                
                <div class="col-md-4 col-lg-3">
                    <h6 class="text-white fw-bold mb-3">Community</h6>
                    <div class="d-flex gap-2">
                        <a href="https://www.instagram.com/jukiverse.id/" class="social-icon" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-discord"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-5 pt-4 border-top border-white border-opacity-10 text-center">
                <p class="small mb-0">&copy; {{ date('Y') }} Jukiverse. Crafted for the best gaming experience.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>