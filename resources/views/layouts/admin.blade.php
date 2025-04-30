<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - Si Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header class="header text-white text-center py-3 bg-dark">
        <div class="container">
            <h1 class="mb-0">Dashboard Admin</h1>
            <p class="lead">Kelola Data Peminjaman Fasilitas Kampus</p>
        </div>
    </header>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar py-4">
                <div class="position-sticky">
                    <!-- Logo dan Judul -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 60px;">
                        <h5 class="mt-2 mb-0" style="font-weight: bold;">Si Pinjam</h5>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-decoration-none {{ Request::is('admin/dashboard') ? 'active' : '' }}" 
                            href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-decoration-none {{ Request::is('admin/ruangan*') ? 'active' : '' }}" 
                            href="{{ route('admin.ruangan.index') }}">
                                <i class="fas fa-door-open"></i> Kelola Ruangan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-decoration-none {{ Request::is('admin/peminjaman*') ? 'active' : '' }}" 
                            href="{{ route('admin.peminjaman.index') }}">
                                <i class="fas fa-calendar-check"></i> Kelola Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-decoration-none {{ Request::is('admin/laporan*') ? 'active' : '' }}" 
                            href="{{ route('admin.laporan.index') }}">
                                <i class="fas fa-file-alt"></i> Lihat Laporan
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link text-danger border-0 bg-transparent">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-dark text-white text-center">
        <div class="container">
            <small>© 2025 - Dashboard Admin Si Pinjam</small>
        </div>
        <p class="rahasia">F A W, Zahra,Nabila,Grace, Irfan,Adji,Riswan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    @yield('scripts')
    @stack('scripts')
</body>
</html>