<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    @hasSection('title')
        Si Pinjam - @yield('title')
    @else
        Si Pinjam
    @endif
</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header -->
    <header class="header text-white text-center py-3">
        <div class="container">
            <h1 class="header-title mb-0">Si Pinjam</h1>
            <p class="header-subtitle">@yield('header-subtitle', 'Sistem Informasi Peminjaman')</p>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-navbar">
                </div>
            </a>
            <span class="brand-text">Si Pinjam</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ruangan.*') ? 'active' : '' }}" 
                           href="{{ route('ruangan.index') }}">Ruangan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="peminjamanDropdown" 
                           data-bs-toggle="dropdown">Peminjaman</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('pinjem.create') }}">Pinjam Ruangan</a></li>
                            <li><a class="dropdown-item" href="{{ route('pinjem.status') }}">Status Peminjaman</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" data-bs-toggle="dropdown">
                            <img src="{{ Auth::user()->foto_url ?? 'https://png.pngtree.com/png-vector/20230531/ourlarge/pngtree-young-girl-standing-ready-coloring-page-vector-png-image_6787733.png' }}" alt="Foto Profil" class="rounded-circle" width="32" height="32">
                            <span class="ms-2">{{ Auth::user()->name }}</span>
                            @if($notifikasi->count() > 0)
                                <span class="badge bg-danger ms-1">{{ $notifikasi->count() }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('helpdesk') ? 'active' : '' }}" href="{{ route('helpdesk') }}">
                            Helpdesk
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-bottom">
            Copyright &copy; {{ date('Y') }} - Developed by <a href="#">Informatika FT UNTIRTA</a>
        </div>
        <p class="rahasia">F A W, Zahra,Nabila,Grace, Irfan,Adji,Riswan</p>
    </footer>
    


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>