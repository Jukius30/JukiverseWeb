<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jukiverse')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --space-dark: #0a0e27;
            --space-purple: #6a2d5c;
            --space-blue: #1e3a8a;
            --neon-cyan: #00d9ff;
            --neon-purple: #c084fc;
        }
        
        body {
            background: linear-gradient(135deg, var(--space-dark) 0%, var(--space-blue) 100%);
            color: #e0e0e0;
            font-family: 'Inter', sans-serif;
        }
        
        header {
            background: rgba(10, 14, 39, 0.95) !important;
            border-bottom: 2px solid var(--neon-cyan);
        }
        
        .navbar-brand, .nav-link {
            color: var(--neon-cyan) !important;
        }
        
        .nav-link:hover {
            color: var(--neon-purple) !important;
            text-shadow: 0 0 10px var(--neon-cyan);
        }
        
        main {
            background: linear-gradient(to bottom, rgba(106, 45, 92, 0.1), rgba(30, 58, 138, 0.1));
        }
        
        footer {
            background: rgba(10, 14, 39, 0.95) !important;
            border-top: 2px solid var(--neon-purple);
        }
        
        footer a:hover {
            color: var(--neon-cyan) !important;
            text-shadow: 0 0 10px var(--neon-cyan);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="shadow-sm">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" height="40">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav gap-3">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/store">Store</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="min-vh-100">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" height="40" class="mb-3">
                    <p>Your description here. Jukiverse is dedicated to providing quality services.</p>
                </div>
                <div class="col-md-4">
                    <h5 style="color: var(--neon-cyan);">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="/store" class="text-light text-decoration-none">Store</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 style="color: var(--neon-purple);">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="https://www.instagram.com/jukiverse.id/" class="text-light"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-light">
            <p class="text-center mb-0">&copy; 2026 Jukiverse. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>