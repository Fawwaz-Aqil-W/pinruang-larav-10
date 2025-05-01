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
  <h2 class="fw-bold text-center mb-5">Panduan Mengedit Permintaan Peminjaman</h2>

  <!-- Step 1 -->
  <div class="step-box">
    <h5 class="fw-semibold">1. Masuk ke menu <em>Status Peminjaman</em></h5>
    <p>Pada navbar, pilih menu <strong>Peminjaman</strong> lalu <strong>Status Peminjaman</strong> untuk melihat status peminjaman ruangan</p>
  </div>

  <!-- Step 2 -->
  <div class="step-box">
    <h5 class="fw-semibold">2. Cari peminjaman yang berstatus <em>Pending</em></h5>
    <p>Hanya peminjaman dengan status <strong>Pending</strong> yang dapat diedit.</p>
    <p>Setelah menemukan peminjaman yang ingin diubah, klik tombol <strong>Edit</strong> untuk masuk ke halaman pengeditan.</p>
    <img src="{{ asset('images/edit1.png') }}" class="step-img">
  </div>

  <!-- Step 4 -->
  <div class="step-box">
    <h5 class="fw-semibold">4. Ubah informasi sesuai kebutuhan</h5>
    <p>Anda dapat mengubah informasi seperti tanggal, waktu, atau alasan peminjaman. Pastikan data baru sesuai dengan kebutuhan Anda. Lalu <strong>Simpan Perubahan</strong></p>
    <img src="{{ asset('images/edit2.png') }}" class="step-img">
  </div>

  <!-- Step 6 -->
  <div class="step-box">
    <h5 class="fw-semibold">6. Setelah Disetujui, pengguna dapat mengunduh <em>Bukti Peminjaman</em></h5>
    <p>Jika status peminjaman Anda telah <strong>Disetujui</strong> atau <strong>Ditolak</strong>, maka tidak akan tersedia tombol Edit.</p>
    <img src="{{ asset('images/edit3.png') }}" class="step-img">
  </div>
</div>
@endsection
