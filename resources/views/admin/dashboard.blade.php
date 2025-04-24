@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4">Ringkasan</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Ruangan</h5>
                <p class="card-text fs-3">{{ $total_ruangan }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total User</h5>
                <p class="card-text fs-3">{{ $total_user }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Peminjaman</h5>
                <p class="card-text fs-3">{{ $total_peminjaman }}</p>
            </div>
        </div>
    </div>
</div>

<hr>
<h4>Kalender Peminjaman</h4>
<div id='calendar' class="bg-white p-3 rounded shadow-sm mb-4"></div>

<hr>
<h4>Peminjaman Terbaru</h4>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>User</th>
                <th>Ruangan</th>
                <th>Alasan Pinjam</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Alasan Ditolak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recent_peminjaman as $pinjam)
            <tr>
                <td>{{ $pinjam->user->name }}</td>
                <td>{{ $pinjam->ruangan->nama }}</td>
                <td>{{ $pinjam->alasan }}</td>
                <td>
                    @if($pinjam->mulai && $pinjam->selesai)
                        {{ \Carbon\Carbon::parse($pinjam->mulai)->format('d-m-Y H:i') }}<br>
                        s/d<br>
                        {{ \Carbon\Carbon::parse($pinjam->selesai)->format('d-m-Y H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $pinjam->status_color }}">
                        {{ $pinjam->status }}
                    </span>
                </td>
                <td>
                    {{ $pinjam->alasan_ditolak ?? '-' }}
                </td>
                <td>
                    @if($pinjam->status == 'pending')
                        <button class="btn btn-success btn-sm approve-btn" data-id="{{ $pinjam->id }}">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                        <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $pinjam->id }}">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Selesai</button>
                        <button class="btn btn-warning btn-sm cancel-btn" data-id="{{ $pinjam->id }}">
                            <i class="fas fa-undo"></i> Batalkan
                        </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek', // gunakan tampilan mingguan agar scroll jam muncul
        events: @json($calendar_events),
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'id',
        weekends: true,
        slotMinTime: '00:00:00',
        slotMaxTime: '24:00:00',
        height: 500, // atur tinggi kalender agar tidak terlalu besar
        length: 7, // jumlah hari dalam tampilan mingguan
        scrollTime: '07:00:00', // posisi scroll awal
        allDaySlot: true,
        slotDuration: '01:00:00',
    });
    calendar.render();

    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            if (confirm('Yakin ingin menyetujui peminjaman ini?')) {
                const id = this.dataset.id;
                try {
                    const response = await fetch(`/admin/peminjaman/${id}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await response.json();
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal menyetujui peminjaman');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan saat menyetujui');
                }
            }
        });
    });

    // Reject
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const reason = prompt('Alasan penolakan:');
            if (reason) {
                const id = this.dataset.id;
                try {
                    const response = await fetch(`/admin/peminjaman/${id}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ reason: reason })
                    });
                    const data = await response.json();
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal menolak peminjaman');
                    }
                } catch (error) {
                    alert('Terjadi kesalahan saat menolak');
                }
            }
        });
    });
});
// Cancel (batalkan ke pending)
document.querySelectorAll('.cancel-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        if (confirm('Yakin ingin membatalkan status peminjaman ini menjadi pending?')) {
            const id = this.dataset.id;
            try {
                const response = await fetch(`/admin/peminjaman/${id}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal membatalkan peminjaman');
                }
            } catch (error) {
                alert('Terjadi kesalahan saat membatalkan');
            }
        }
    });
});
</script>
@endsection