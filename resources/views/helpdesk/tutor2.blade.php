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
    <p>Masuk ke halaman daftar ruangan, lalu scroll daftar untuk menemukan ruangan yang tersedia, pilih salah satu ruangan.</p>
    <img src="{{ asset('images/ruangan1.png') }}" class="step-img"> 
    <img src="{{ asset('images/ruangan2.png') }}" class="step-img">
  </div>

  <!-- Step 2 -->
  <div class="step-box">
    <h5 class="fw-semibold">2. Klik tombol <em>Pinjam</em> pada ruangan tersebut</h5>
    <p>Setelah menemukan ruangan yang sesuai, klik tombol <strong>Pinjam</strong> untuk melanjutkan proses peminjaman.</p>
    <img src="{{ asset('images/ruangan3.png') }}" class="step-img">
    <p>Atau, bisa juga dengan klik navbar <strong>Peminjamaman</strong> lalu ke <strong>Pinjam Ruangan</strong> untuk langsung ke formulir peminjaman</p>
    <img src="{{ asset('images/ruangan4.png') }}" class="step-img">
  </div>

  <!-- Step 3 -->
  <div class="step-box">
    <h5 class="fw-semibold">3. Isi formulir peminjaman</h5>
    <p>Lengkapi formulir peminjaman dengan informasi berikut:</p>
    <ul>
      <li>Ruangan yang ingin dipinjam</li>
      <li>Tanggal peminjaman</li>
      <li>Jam mulai dan jam selesai</li>
      <li>Alasan peminjaman</li>
      <li>Pastikan semua data sudah benar, lalu klik tombol <strong>Ajukan Peminjaman</strong></li>
    </ul>
    <img src="{{ asset('images/ruangan5.png') }}" class="step-img">
  </div>

  <!-- Step 4 -->
  <div class="step-box">
    <h5 class="fw-semibold">5. Permintaan Anda akan berstatus <em>Pending</em></h5>
    <p>Permintaan Anda akan diproses dan menunggu persetujuan dari admin. Anda bisa memantau statusnya di halaman <strong>Status Peminjaman</strong>.</p>
    <p>Notifikasi terkait status peminajaman juga akan muncul di profil</p>
    <img src="{{ asset('images/notif.png') }}" class="step-img">
  </div>
</div>
@endsection
