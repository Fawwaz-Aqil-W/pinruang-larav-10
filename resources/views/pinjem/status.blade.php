<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<header class="header text-white text-center py-3">
    <div class="container">
        <h1 class="header-title mb-0">Si Pinjam</h1>
        <p class="header-subtitle">Sistem Informasi Peminjaman</p>
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
        <div class="col-12 d-flex justify-content-center">
            <div class="card shadow-sm w-100" style="max-width:1300px;">
                <div class="card-header custom-header">
                    <h4>Status Peminjaman</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>ID Peminjaman</th>
                                    <th>Nama Ruangan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th>Alasan di Tolak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $index => $pinjem)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pinjem->id }}</td>
                                    <td>{{ $pinjem->ruangan->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pinjem->mulai)->format('d-m-Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pinjem->selesai)->format('d-m-Y H:i') }}</td>
                                    <td>
                                        @if($pinjem->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($pinjem->status == 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $pinjem->alasan_ditolak ?? '-' }}
                                    </td>
                                    <td>
                                        @if($pinjem->status == 'pending')
                                            <button type="button" class="btn btn-primary btn-sm btn-edit-pinjam"
                                                data-pinjam='@json($pinjem)'>Edit</button>
                                            <form action="{{ route('pinjem.destroy', $pinjem->id) }}" 
                                                method="POST" 
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Edit</button>
                                            <button class="btn btn-danger btn-sm" disabled>Hapus</button>
                                        @endif
                                        @if($pinjem->status == 'disetujui')
                                            <a href="{{ route('pinjem.bukti', $pinjem->id) }}" target="_blank" class="btn btn-success btn-sm">
                                                <i class="fas fa-file-pdf"></i> Bukti PDF
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data peminjaman</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Peminjaman -->
<div class="modal fade" id="editPinjamModal" tabindex="-1" aria-labelledby="editPinjamLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="form-edit-pinjam" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPinjamLabel">Edit Peminjaman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_id" name="id">
          <div class="mb-3">
            <label for="edit_mulai" class="form-label">Waktu Mulai</label>
            <input type="datetime-local" class="form-control" id="edit_mulai" name="mulai" required>
          </div>
          <div class="mb-3">
            <label for="edit_selesai" class="form-label">Waktu Selesai</label>
            <input type="datetime-local" class="form-control" id="edit_selesai" name="selesai" required>
          </div>
          <div class="mb-3">
            <label for="edit_alasan" class="form-label">Alasan</label>
            <input type="text" class="form-control" id="edit_alasan" name="alasan" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<footer class="footer">
    <div class="footer-bottom">
        Copyright &copy; {{ date('Y') }} - Developed by <a href="#">Informatika FT UNTIRTA</a>
    </div>
    <p class="rahasia">F A W, Zahra,Nabila,Grace, Irfan,Adji,Riswan</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Saat klik tombol edit
    document.querySelectorAll('.btn-edit-pinjam').forEach(btn => {
        btn.addEventListener('click', function() {
            const pinjam = JSON.parse(this.dataset.pinjam);
            document.getElementById('edit_id').value = pinjam.id;
            document.getElementById('edit_mulai').value = pinjam.mulai.replace(' ', 'T');
            document.getElementById('edit_selesai').value = pinjam.selesai.replace(' ', 'T');
            document.getElementById('edit_alasan').value = pinjam.alasan;
            document.getElementById('form-edit-pinjam').action = `/pinjem/${pinjam.id}`;
            const modalEl = document.getElementById('editPinjamModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });
    });

    // Submit form edit via AJAX (opsional, agar reload otomatis)
    document.getElementById('form-edit-pinjam').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const data = new FormData(form);
        const url = form.action;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: new URLSearchParams(data)
        });
        if (response.ok) {
            window.location.reload();
        } else {
            alert('Gagal update peminjaman');
        }
    });
});
</script>
<style>
.table-responsive table {
    width: 100% !important;
    min-width: 900px;
    table-layout: auto;
}
</style>
</body>
</html>