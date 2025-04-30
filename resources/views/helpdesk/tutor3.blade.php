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
    <h5 class="fw-semibold">1. Masuk ke menu <em>Peminjaman Saya</em></h5>
    <img src="edit-step1.png" alt="Masuk ke menu Peminjaman Saya" class="step-img img-fluid">
    <p>Pada halaman utama, pilih menu <strong>Peminjaman Saya</strong> untuk melihat daftar peminjaman Anda.</p>
  </div>

  <!-- Step 2 -->
  <div class="step-box">
    <h5 class="fw-semibold">2. Cari peminjaman yang berstatus <em>Pending</em></h5>
    <img src="edit-step2.png" alt="Pilih status pending" class="step-img img-fluid">
    <p>Hanya peminjaman dengan status <strong>Pending</strong> yang dapat diedit. Gunakan fitur pencarian atau filter jika perlu.</p>
  </div>

  <!-- Step 3 -->
  <div class="step-box">
    <h5 class="fw-semibold">3. Klik tombol <em>Edit</em></h5>
    <img src="edit-step3.png" alt="Klik tombol Edit" class="step-img img-fluid">
    <p>Setelah menemukan peminjaman yang ingin diubah, klik tombol <strong>Edit</strong> untuk masuk ke halaman pengeditan.</p>
  </div>

  <!-- Step 4 -->
  <div class="step-box">
    <h5 class="fw-semibold">4. Ubah informasi sesuai kebutuhan</h5>
    <img src="edit-step4.png" alt="Ubah informasi peminjaman" class="step-img img-fluid">
    <p>Anda dapat mengubah informasi seperti tanggal, waktu, atau alasan peminjaman. Pastikan data baru sesuai dengan kebutuhan Anda.</p>
  </div>

  <!-- Step 5 -->
  <div class="step-box">
    <h5 class="fw-semibold">5. Klik tombol <em>Update</em></h5>
    <img src="edit-step5.png" alt="Klik tombol Update" class="step-img img-fluid">
    <p>Setelah semua informasi diperbarui, klik tombol <strong>Update</strong> untuk menyimpan perubahan.</p>
  </div>

  <!-- Step 6 -->
  <div class="step-box">
    <h5 class="fw-semibold">6. Setelah Disetujui/Ditolak, tidak bisa diedit</h5>
    <img src="edit-step6.png" alt="Tidak bisa diedit jika sudah disetujui" class="step-img img-fluid">
    <p>Jika status peminjaman Anda telah <strong>Disetujui</strong> atau <strong>Ditolak</strong>, maka tidak akan tersedia tombol Edit.</p>
  </div>
</div>
@endsection
