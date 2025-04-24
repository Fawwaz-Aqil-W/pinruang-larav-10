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
    <form class="row g-3 mb-4" id="formFilter" method="GET">
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
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
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
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $index => $pinjam)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pinjam->user->name }}</td>
                            <td>{{ $pinjam->ruangan->nama }}</td>
                            <td>{{ $pinjam->tanggal }}</td>
                            <td>{{ $pinjam->status }}</td>
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