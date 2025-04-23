@extends('layouts.app')

@section('title', 'Pengajuan Peminjaman')

@section('content')
<div class="profile-section py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header custom-header">
                    <h5 class="mb-1">Form Peminjaman</h5>
                </div>
                <div class="card-body">
                    <form id="form-peminjaman" action="{{ route('pinjem.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_ruangan" value="R001">

                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select id="jurusan" name="jurusan" class="form-select @error('jurusan') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Jurusan --</option>
                                <option value="Informatika">Informatika</option>
                                <option value="Mesin">Mesin</option>
                                <option value="Elektro">Elektro</option>
                                <option value="Industri">Industri</option>
                            </select>
                            @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ruangan" class="form-label">Ruangan</label>
                            <select id="ruangan" name="id_ruangan" class="form-select @error('id_ruangan') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Ruangan --</option>
                                @foreach($ruangan as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama }} - {{ $r->gedung }}</option>
                                @endforeach
                            </select>
                            @error('id_ruangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mulai" class="form-label">Mulai Pinjam</label>
                            <input type="datetime-local" class="form-control @error('mulai') is-invalid @enderror" 
                                   id="mulai" name="mulai" required>
                            @error('mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="selesai" class="form-label">Selesai Pinjam</label>
                            <input type="datetime-local" class="form-control @error('selesai') is-invalid @enderror" 
                                   id="selesai" name="selesai" required>
                            @error('selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alasan" class="form-label">Tujuan</label>
                            <input type="text" class="form-control @error('alasan') is-invalid @enderror" 
                                   id="alasan" name="alasan" required>
                            @error('alasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-main">Ajukan Peminjaman</button>
                    </form>

                    <div id="alert-message" class="alert alert-success mt-4 d-none">
                        <strong>Pengajuan Berhasil!</strong> Peminjaman Anda telah berhasil diajukan.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-peminjaman');
    const alertBox = document.getElementById('alert-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            alertBox.classList.remove('d-none');
            form.reset();
            
            setTimeout(() => {
                alertBox.classList.add('d-none');
            }, 5000);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endsection