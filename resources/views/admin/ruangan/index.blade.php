@extends('layouts.admin')

@section('title', 'Kelola Ruangan')

@section('content')
<section id="kelola-ruangan">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Ruangan</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ruanganModal">
            <i class="fas fa-plus"></i> Tambah Ruangan
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Ruangan</th>
                            <th>Gedung</th>
                            <th>Kapasitas</th>
                            <th>Gambar</th>
                            <th>Fasilitas</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruangan as $room)
                        <tr>
                            <td>{{ $room->nama }}</td>
                            <td>{{ $room->gedung }}</td>
                            <td>{{ $room->kapasitas }}</td>
                            <td>
                                <img src="{{ $room->gambar ? asset('storage/'.$room->gambar) : ($room->gambar_url ?? asset('images/foto2.png')) }}"
     alt="Gambar {{ $room->nama }}"
     width="100"
     class="img-thumbnail">
                            </td>
                            <td>{{ $room->fasilitas ?? '' }}</td>
                            <td>{{ $room->deskripsi ?? '' }}</td>
                            <td>
                                <a href="{{ route('admin.ruangan.edit', $room->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.ruangan.destroy', $room->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah/Edit Ruangan -->
@include('admin.ruangan.modal')
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('ruanganModal'));
    const form = document.getElementById('formRuangan');
    
    // Add new room
    document.querySelector('[data-bs-target="#ruanganModal"]').addEventListener('click', function() {
        form.reset();
        form.action = "{{ route('admin.ruangan.store') }}";
        form.querySelector('input[name="_method"]').value = 'POST';
        document.querySelector('.modal-title').textContent = 'Tambah Ruangan';
        document.getElementById('current_image').style.display = 'none';
    });

    // Edit room
    document.querySelectorAll('.edit-room').forEach(button => {
        button.addEventListener('click', async function() {
            const id = this.dataset.id;
            try {
                const response = await fetch(`/admin/ruangan/${id}/edit`);
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();

                form.reset();
                form.action = `/admin/ruangan/${id}`;
                form.querySelector('input[name="_method"]').value = 'PUT';
                document.querySelector('.modal-title').textContent = 'Edit Ruangan';

                document.getElementById('nama').value = data.nama ?? '';
                document.getElementById('kode_ruangan').value = data.kode_ruangan ?? '';
                document.getElementById('gedung').value = data.gedung ?? '';
                document.getElementById('kapasitas').value = data.kapasitas ?? '';
                document.getElementById('fasilitas').value = data.fasilitas ?? '';
                document.getElementById('deskripsi').value = data.deskripsi ?? '';

                const img = document.getElementById('current_image');
                if (data.gambar) {
                    img.src = '/storage/' + data.gambar;
                    img.style.display = 'block';
                } else if (data.gambar_url) {
                    img.src = data.gambar_url;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }

                modal.show();
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal mengambil data ruangan');
            }
        });
    });

});
</script>
@endsection