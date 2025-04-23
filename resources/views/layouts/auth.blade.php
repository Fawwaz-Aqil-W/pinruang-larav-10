<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Si Minjem') }} - @yield('title')</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="overlay"></div>
    
    @yield('content')

    <footer class="footer">
        <div class="footer-bottom">
            Copyright &copy; {{ date('Y') }} - Developed by <a href="#">Informatika FT UNTIRTA</a>
        </div>
    </footer>
</body>
</html>