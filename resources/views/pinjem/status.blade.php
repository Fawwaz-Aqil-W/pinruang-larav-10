@extends('layouts.app')

@section('title', 'Status Peminjaman')

@section('content')
<section class="status-section py-5">
    <div class="container">
        <div class="card shadow-sm">
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
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Tambahkan di bawah tabel pada status.blade.php --}}
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

@push('scripts')
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
            new bootstrap.Modal(document.getElementById('editPinjamModal')).show();
        });
    });
});
</script>
@endpush
@endsection