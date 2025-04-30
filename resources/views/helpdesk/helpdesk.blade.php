@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
 <!-- Helpdesk Content -->
 <section class="helpdesk-section py-5 mt-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Panduan Penggunaan Si Pinjam</h2>
    <div class="row g-4">
      <!-- Panduan: Melihat Ketersediaan -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 text-center">
          <img src="cek_kalender.png" class="card-img-top img-fluid" alt="Cek Ketersediaan">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Cek Ketersediaan Ruangan</h5>
            <p class="card-text flex-grow-1">Lihat kalender untuk mengetahui ruangan kosong sebelum meminjam.</p>
            <a href="{{ route('helpdesk.tutor1') }}" class="btn btn-primary mt-auto">Lihat Panduan</a>
          </div>
        </div>
      </div>

      <!-- Panduan: Mengajukan Peminjaman -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 text-center">
          <img src="pinjam_ruangan.png" class="card-img-top img-fluid" alt="Pinjam Ruangan">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Ajukan Peminjaman</h5>
            <p class="card-text flex-grow-1">Cara mengisi form untuk meminjam ruangan dengan benar.</p>
            <a href="{{ route('helpdesk.tutor2') }}" class="btn btn-primary mt-auto">Lihat Panduan</a>
          </div>
        </div>
      </div>

      <!-- Panduan: Mengedit Peminjaman -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 text-center">
          <img src="status.png" class="card-img-top img-fluid" alt="Status Peminjaman">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Edit Peminjaman</h5>
            <p class="card-text flex-grow-1">Edit peminjamanmu sebelum di approve</p>
            <a href="{{ route('helpdesk.tutor3') }}" class="btn btn-primary mt-auto">Lihat Panduan</a>
          </div>
        </div>
      </div>

      <!-- Tambah lebih banyak panduan jika diperlukan -->
    </div>
  </div>
</section>
@endsection
