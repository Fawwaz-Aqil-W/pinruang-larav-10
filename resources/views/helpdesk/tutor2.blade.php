@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<!-- Tombol Kembali -->
<div class="container mt-3">
    <a href="javascript:history.back()" class="btn btn-outline-secondary">
      &larr; Kembali
    </a>
  </div>

<!-- Konten Panduan -->
<div class="container mt-4">
  <h2 class="fw-bold text-center mb-5">Panduan Melakukan Peminjaman Ruangan</h2>

  <!-- Step 1 -->
  <div class="step-box">
    <h5 class="fw-semibold">1. Cari ruangan yang ingin Anda pinjam</h5>
    <img src="step1.png" alt="Langkah 1" class="step-img img-fluid">
    <p>Masuk ke halaman daftar ruangan, lalu gunakan filter pencarian atau scroll daftar untuk menemukan ruangan yang tersedia.</p>
  </div>

  <!-- Step 2 -->
  <div class="step-box">
    <h5 class="fw-semibold">2. Klik tombol <em>Pinjam</em> pada ruangan tersebut</h5>
    <img src="step2.png" alt="Langkah 2" class="step-img img-fluid">
    <p>Setelah menemukan ruangan yang sesuai, klik tombol <strong>Pinjam</strong> untuk melanjutkan proses peminjaman.</p>
  </div>

  <!-- Step 3 -->
  <div class="step-box">
    <h5 class="fw-semibold">3. Isi formulir peminjaman</h5>
    <img src="step3.png" alt="Langkah 3" class="step-img img-fluid">
    <p>Lengkapi formulir peminjaman dengan informasi berikut:</p>
    <ul>
      <li>Ruangan yang ingin dipinjam</li>
      <li>Tanggal peminjaman</li>
      <li>Jam mulai dan jam selesai</li>
      <li>Alasan peminjaman</li>
    </ul>
  </div>

  <!-- Step 4 -->
  <div class="step-box">
    <h5 class="fw-semibold">4. Klik tombol <em>Ajukan Peminjaman</em></h5>
    <img src="step4.png" alt="Langkah 4" class="step-img img-fluid">
    <p>Pastikan semua data sudah benar, lalu klik tombol <strong>Ajukan Peminjaman</strong>.</p>
  </div>

  <!-- Step 5 -->
  <div class="step-box">
    <h5 class="fw-semibold">5. Permintaan Anda akan berstatus <em>Pending</em></h5>
    <img src="step5.png" alt="Langkah 5" class="step-img img-fluid">
    <p>Permintaan Anda akan diproses dan menunggu persetujuan dari admin. Anda bisa memantau statusnya di halaman Status Peminjaman.</p>
  </div>
</div>
@endsection
