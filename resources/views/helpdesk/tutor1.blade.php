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
<div class="container">
    <h2 class="text-center mb-4 fw-bold mt-5">Panduan Melihat Ketersediaan Ruangan (Kalender)</h2>
  
    <div class="step-box">
      <h5 class = fw-semibold>1. Buka halaman <em>Home</em></h5>
      <p>Pada halaman utama, scroll kebawah kamu akan menemukan form pengecekan ketersediaan ruangan berdasarkan tanggal dan gedung.</p>
      <img src="{{ asset('images/kalender1.png') }}" alt="Step 1 - Home Page" class="step-img">
    </div>
  
    <div class="step-box">
      <ul>
        <h5 class = fw-semibold>2. Pilih Tanggal dan Gedung</h5>
        <li><strong>Tanggal Awal:</strong> Tanggal mulai peminjaman.</li>
        <li><strong>Tanggal Akhir:</strong> Tanggal selesai peminjaman.</li>
        <li><strong>Gedung:</strong> Pilih gedung atau ruangan yang ingin dicek.</li>
      </ul>
      <img src="{{ asset('images/kalender2.png') }}" alt="Step 1 - Pilih Tanggal dan Gedung" class="step-img">
    </div>
  
    <div class="step-box">
      <h5 class = fw-semibold>3. Klik tombol <em>Check</em></h5>
      <p>Sistem akan menampilkan status ketersediaan ruangan berdasarkan input yang kamu berikan.</p>
      <p><strong>Catatan:</strong> Pastikan ruangan tersedia sebelum membuat permintaan peminjaman.</p>
      <img src="{{ asset('images/kalender3.png') }}" alt="Step 3 - Lihat Hasil" class="step-img">
    </div>
</div>
@endsection
