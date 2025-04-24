@extends('layouts.app')

@section('title', 'Detail Ruangan')

@section('styles')
<link href="{{ asset('vendor/fullcalendar/dist/index.global.min.js') }}" rel="stylesheet">
<style>
#calendar {
    max-width: 1200px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>
@endsection

@section('content')
<div class="container my-5">
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
@endsection

@section('scripts')
<script src="{{ asset('vendor/fullcalendar/dist/index.global.js') }}"></script>
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
        slotMinTime: '07:00:00',
        slotMaxTime: '18:00:00',
        allDaySlot: false,
        weekends: false,
        selectable: true,
        dayMaxEvents: true,
        height: 'auto',
        locale: 'id',
        events: `/ruangan/schedule/{{ $ruangan->id }}`,
        eventDidMount: function(info) {
            info.el.setAttribute('data-status', info.event.extendedProps.status);
            
            // Add tooltip
            var tooltip = new Tooltip(info.el, {
                title: info.event.title,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
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
@endsection