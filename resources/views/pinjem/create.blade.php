@extends('layouts.app')

@section('title', 'Pengajuan Peminjaman')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    .fc-event {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
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
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
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
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            alertBox.classList.remove('d-none');
            
            if (data.status === 'success') {
                alertBox.classList.remove('alert-danger');
                alertBox.classList.add('alert-success');
                alertBox.textContent = data.message;
                form.reset();
                
                // Refresh calendar
                if (ruanganSelect.value) {
                    ruanganSelect.dispatchEvent(new Event('change'));
                }
            } else {
                alertBox.classList.remove('alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = data.message || 'Terjadi kesalahan saat memproses peminjaman';
            }
            
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
@endsection