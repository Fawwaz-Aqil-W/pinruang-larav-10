@extends('layouts.admin')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Peminjaman</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $pinjam)
                        <tr>
                            <td>{{ $pinjam->user->name }}</td>
                            <td>{{ $pinjam->ruangan->nama }}</td>
                            <td>{{ $pinjam->tanggal }}</td>
                            <td>
                                <span class="badge bg-{{ $pinjam->status_color }}">
                                    {{ $pinjam->status }}
                                </span>
                            </td>
                            <td>
                                @if($pinjam->status == 'pending')
                                    <button class="btn btn-success btn-sm approve-btn" 
                                            data-id="{{ $pinjam->id }}">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                    <button class="btn btn-danger btn-sm reject-btn" 
                                            data-id="{{ $pinjam->id }}">
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Approve
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