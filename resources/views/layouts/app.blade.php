<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Si Minjem - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header class="header text-white text-center py-3">
        <div class="container">
            <h1 class="mb-0">Si Pinjam</h1>
            <p class="lead">Sistem Informasi Peminjaman Fasilitas Kampus</p>
        </div>
    </header>

    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-bottom">
            Copyright &copy; {{ date('Y') }} - Developed by <a href="#">Informatika FT UNTIRTA</a>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>