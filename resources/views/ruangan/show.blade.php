<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Si Minjem') }} <title>Detail Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        #calendar {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            font-size: 0.95rem;
            min-height: 400px;
            overflow-y: auto;
        }
        .fc { font-size: 0.95rem; }
    </style>
</head>
<header class="header text-white text-center py-3">
    <div class="container">
        <h1 class="mb-0">Si Pinjam</h1>
        <p class="lead">@yield('header-subtitle', 'Sistem Informasi Peminjaman')</p>
    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Si Minjem</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" 
                       href="{{ route('profile') }}">Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<body>
    
    <div class="container my-5" style="margin-bottom: 60px;">
        <div class="row">
            <div class="col-md-12">
                <div class="room-info mb-4">
                    <h3>{{ $ruangan->nama }}</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $ruangan->gambar_url ?? 'https://loremflickr.com/320/240/building' }}" 
                                 alt="{{ $ruangan->nama }}" 
                                 class="img-fluid mb-3 rounded">
                        </div>
                        <div class="col-md-8">
                            <p><strong>Gedung:</strong> {{ $ruangan->gedung }}</p>
                            <p><strong>Kapasitas:</strong> {{ $ruangan->kapasitas }} orang</p>
                            <p><strong>Fasilitas:</strong> {{ $ruangan->fasilitas ?? 'Proyektor, AC, Meja & Kursi' }}</p>
                            <p><strong>Deskripsi:</strong> {{ $ruangan->deskripsi ?? 'Ruang ini digunakan untuk kuliah dan seminar.' }}</p>
                            <a href="{{ route('pinjem.create', ['ruangan_id' => $ruangan->id]) }}" 
                               class="btn btn-primary">
                                Pinjam Ruangan
                            </a>
                        </div>
                    </div>
                </div>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-bottom">
            Copyright &copy; {{ date('Y') }} - Developed by <a href="#">Informatika FT UNTIRTA</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            initialView: 'timeGridWeek',
            slotMinTime: '00:00:00',
            slotMaxTime: '24:00:00',
            allDaySlot: false,
            weekends: false,
            selectable: true,
            dayMaxEvents: true,
            height: 600,
            scrollTime: '07:00:00',
            locale: 'id',
            events: `/ruangan/schedule/{{ $ruangan->id }}`,
            eventDidMount: function(info) {
                info.el.setAttribute('data-status', info.event.extendedProps.status);
            },
            eventContent: function(arg) {
                return {
                    html: `<div class="fc-event-main-frame">
                        <div class="fc-event-time">${arg.timeText}</div>
                        <div class="fc-event-title">${arg.event.title}</div>
                    </div>`
                };
            }
        });
        calendar.render();
    });
    </script>
</body>
</html>