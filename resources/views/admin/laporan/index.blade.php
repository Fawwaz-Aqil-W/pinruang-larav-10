@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h3>Laporan Peminjaman</h3>
        <div>
            <button class="btn btn-success me-2" onclick="exportData('excel')">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <button class="btn btn-danger" onclick="exportData('pdf')">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>

    <!-- Filter Laporan -->
    <form class="row align-items-end g-3 mb-4" id="formFilter" method="GET">
        <div class="col-md-3">
            <label for="filterStatus" class="form-label">Status</label>
            <select class="form-select" id="filterStatus" name="status">
                <option value="">Semua</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="filterTanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="filterTanggal" name="tanggal" 
                   value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-3">
            <label for="filterRuangan" class="form-label">Ruangan</label>
            <select class="form-select" id="filterRuangan" name="ruangan">
                <option value="">Semua</option>
                @foreach($ruangan as $room)
                    <option value="{{ $room->id }}" {{ request('ruangan') == $room->id ? 'selected' : '' }}>
                        {{ $room->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
        <label class="form-label d-block invisible">Terapkan Filter</label>
        <button type="submit" class="btn signin-btn w-100 text-white">
            Terapkan Filter
        </button>
    </div>
    </form>

    <!-- Tabel Laporan -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Ruangan</th>
                            <th>Alasan Peminjaman</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>ACC/Ditolak Oleh</th>
                            <th>Waktu ACC/Ditolak</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $index => $pinjam)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pinjam->user->name }}</td>
                            <td>{{ $pinjam->ruangan->nama }}</td>
                            <td>{{ $pinjam->alasan }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($pinjam->mulai)->translatedFormat('d F Y H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($pinjam->selesai)->translatedFormat('H:i') }}
                            </td>
                            <td>{{ $pinjam->status }}</td>
                            <td>
                                @php
                                    $admin = null;
                                    if ($pinjam->status == 'disetujui' && $pinjam->disetujui_oleh) {
                                        $admin = \App\Models\User::find($pinjam->disetujui_oleh);
                                    } elseif ($pinjam->status == 'ditolak' && $pinjam->ditolak_oleh) {
                                        $admin = \App\Models\User::find($pinjam->ditolak_oleh);
                                    }
                                @endphp
                                {{ $admin ? $admin->name : '-' }}
                            </td>
                            <td>
                                @if($pinjam->status == 'disetujui')
                                    {{ $pinjam->disetujui_pada ? \Carbon\Carbon::parse($pinjam->disetujui_pada)->translatedFormat('d F Y H:i') : '-' }}
                                @elseif($pinjam->status == 'ditolak')
                                    {{ $pinjam->ditolak_pada ? \Carbon\Carbon::parse($pinjam->ditolak_pada)->translatedFormat('d F Y H:i') : '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $pinjam->alasan_ditolak ?? '-' }}</td>
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
function exportData(type) {
    const form = document.getElementById('formFilter');
    const params = new URLSearchParams(new FormData(form)).toString();
    window.location.href = `/admin/laporan/export-${type}?${params}`;
}

// Preserve filter values after page reload
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    const status = urlParams.get('status');
    const tanggal = urlParams.get('tanggal');
    const ruangan = urlParams.get('ruangan');
    
    if (status) document.getElementById('filterStatus').value = status;
    if (tanggal) document.getElementById('filterTanggal').value = tanggal;
    if (ruangan) document.getElementById('filterRuangan').value = ruangan;
});
</script>
@endsection