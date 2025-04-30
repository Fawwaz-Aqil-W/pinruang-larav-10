<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .fc-event { cursor: pointer; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<header class="header text-white text-center py-3">
    <div class="container">
        <h1 class="header-title mb-0">Si Pinjam</h1>
        <p class="header-subtitle">@yield('header-subtitle', 'Sistem Informasi Peminjaman')</p>
    </div>
</header>
<body>
<!-- Navbar -->
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
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ruangan.*') ? 'active' : '' }}" href="{{ route('ruangan.index') }}">Ruangan</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="peminjamanDropdown" data-bs-toggle="dropdown">Peminjaman</a>
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
                    <a class="nav-link" href="#">Helpdesk</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container py-5" style="margin-top: 15px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header custom-header">
                        <h5 class="mb-0">Form Peminjaman Ruangan</h5>
                    </div>
                    <div class="card-body">
                        <form id="form-peminjaman" method="POST" action="{{ route('pinjem.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="ruangan" class="form-label">Pilih Ruangan</label>
                                <select class="form-select @error('id_ruangan') is-invalid @enderror" 
                                        id="ruangan" name="id_ruangan" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($ruangan as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }} - {{ $r->gedung }}</option>
                                    @endforeach
                                </select>
                                @error('id_ruangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tampilkan jurusan user --}}
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->jurusan }}" disabled>
                                <input type="hidden" name="jurusan" value="{{ auth()->user()->jurusan }}">
                            </div>

                            <div class="mb-3">
                                <label for="mulai" class="form-label">Waktu Mulai</label>
                                <input type="datetime-local" class="form-control @error('mulai') is-invalid @enderror" 
                                       id="mulai" name="mulai" required>
                                @error('mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="selesai" class="form-label">Waktu Selesai</label>
                                <input type="datetime-local" class="form-control @error('selesai') is-invalid @enderror" 
                                       id="selesai" name="selesai" required>
                                @error('selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alasan" class="form-label">Alasan Peminjaman</label>
                                <input type="text" class="form-control @error('alasan') is-invalid @enderror" 
                                       id="alasan" name="alasan" required>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn signin-btn">Ajukan Peminjaman</button>
                        </form>

                        <div id="alert-message" class="alert mt-3 d-none"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Jadwal Ruangan</h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label for="start-date" class="form-label">Tanggal Awal</label>
                                <input type="date" id="start-date" name="start_date" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <label for="end-date" class="form-label">Tanggal Akhir</label>
                                <input type="date" id="end-date" name="end_date" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <label for="building" class="form-label">Gedung</label>
                                <select id="building" name="building" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Gedung --</option>
                                    @foreach($gedungs as $gedung)
                                        <option value="{{ $gedung }}">{{ $gedung }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="room" class="form-label">Ruangan</label>
                                <select id="room" name="room" class="form-select">
                                    <option value="">-- Semua Ruangan --</option>
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="signin-btn w-100">Check</button>
                            </div>
                        </form>
                        <div id="calendar" class="mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
<footer class="footer">
    <div class="footer-bottom">
        Copyright &copy; {{ date('Y') }} - Developed by <a href="#">Informatika FT UNTIRTA</a>
    </div>
    <p class="rahasia">F A W, Zahra,Nabila,Grace, Irfan,Adji,Riswan</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form-peminjaman');
        const alertBox = document.getElementById('alert-message');
        const ruanganSelect = document.getElementById('ruangan');
        let calendar;

        // Initialize Calendar
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '07:00:00',
            slotMaxTime: '18:00:00',
            allDaySlot: false,
            weekends: false,
            slotDuration: '01:00:00',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            }
        });
        calendar.render();

        // Load room schedule when room is selected
        ruanganSelect.addEventListener('change', function() {
            const roomId = this.value;
            if (roomId) {
                fetch(`/pinjem/schedule/${roomId}`)
                    .then(response => response.json())
                    .then(events => {
                        calendar.removeAllEvents();
                        calendar.addEventSource(events);
                    });
            }
        });

        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new URLSearchParams(formData)
            })
            .then(async response => {
                let data;
                try {
                    data = await response.json();
                } catch {
                    data = {};
                }
                if (response.ok && data.status === 'success') {
                    alertBox.classList.remove('alert-danger');
                    alertBox.classList.add('alert-success');
                    alertBox.textContent = data.message;
                    form.reset();
                    if (ruanganSelect.value) {
                        ruanganSelect.dispatchEvent(new Event('change'));
                    }
                } else {
                    alertBox.classList.remove('alert-success');
                    alertBox.classList.add('alert-danger');
                    if (data.errors) {
                        alertBox.textContent = Object.values(data.errors).join(', ');
                    } else {
                        alertBox.textContent = data.message || 'Terjadi kesalahan saat memproses peminjaman';
                    }
                }
                alertBox.classList.remove('d-none');
                setTimeout(() => {
                    alertBox.classList.add('d-none');
                }, 5000);
            })
            .catch(error => {
                console.error('Error:', error);
                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = 'Terjadi kesalahan saat menghubungi server';
            });
        });
    });
    </script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    let roomsByGedung = @json($roomsByGedung);

    document.addEventListener('DOMContentLoaded', function() {
        const buildingSelect = document.getElementById('building');
        const roomSelect = document.getElementById('room');
        const calendarEl = document.getElementById('calendar');
        let calendar;

        // Populate ruangan sesuai gedung
        buildingSelect.addEventListener('change', function() {
            const gedung = this.value;
            roomSelect.innerHTML = '<option value="">-- Semua Ruangan --</option>';
            if (roomsByGedung[gedung]) {
                roomsByGedung[gedung].forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.id;
                    opt.textContent = r.nama;
                    roomSelect.appendChild(opt);
                });
            }
        });

        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const roomId = roomSelect.value;
            const gedung = buildingSelect.value;
            const start = document.getElementById('start-date').value;
            const end = document.getElementById('end-date').value;

            if (!gedung) {
                alert('Pilih gedung terlebih dahulu!');
                return;
            }

            if (calendar) calendar.destroy();

            let eventsUrl = '';
            if (roomId) {
                eventsUrl = `/ruangan/schedule/${roomId}?start=${start}&end=${end}`;
            } else {
                eventsUrl = `/ruangan/schedule-gedung/${encodeURIComponent(gedung)}?start=${start}&end=${end}`;
            }

            calendar = new FullCalendar.Calendar(calendarEl, {
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
                selectable: false,
                dayMaxEvents: true,
                height: 600,
                scrollTime: '07:00:00',
                locale: 'id',
                events: eventsUrl,
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
    });
</script>
</body>
</html>