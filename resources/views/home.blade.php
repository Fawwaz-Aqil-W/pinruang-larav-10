@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!--Hero Section-->
<section class="hero-slideshow text-white text-center pt-0 pb-5">
    <div class="container">
        <h2 class="mb-3 ">Selamat Datang di Si Pinjam</h2>
        <p class="lead">Layanan terpadu untuk mempermudah proses peminjaman fasilitas kampus FT secara efisien.</p>
    </div>
</section>

<!-- Cek Tanggal Section -->
<section class="date-checker-section py-4 bg-white">
    <div class="container">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <div class="date-checker bg-light p-4 rounded shadow-sm">
                <form id="filterForm" class="row g-3">
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
                            {{-- Akan diisi via JS --}}
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="signin-btn w-100">Check</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Kalender tampil di bawah form -->
        <div id="calendar" class="mt-4"></div>
    </div>
</section>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    // Data roomsByGedung dari controller
    let roomsByGedung = @json($roomsByGedung);

    // Background slideshow tetap
    const heroSection = document.querySelector('.hero-slideshow');
    const images = [
        "images/foto2.png",
        "images/foto1.png",
    ];
    let index = 0;
    function changeBackground() {
        heroSection.style.backgroundImage = `url(${images[index]})`;
        index = (index + 1) % images.length;
    }
    changeBackground();
    setInterval(changeBackground, 4000);

    // Kalender & filter ruangan
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
@endpush