{{-- filepath: resources/views/admin/helpdesk.blade.php --}}
@extends('layouts.admin')

@section('title', 'Helpdesk Admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Helpdesk Admin Si Pinjam</h2>

    <!-- Nav Section -->
    <nav class="nav nav-pills flex-row justify-content-center mb-4 sticky-top bg-white py-2" style="z-index:10;">
        <a class="nav-link mx-2" href="#dashboard">Dashboard</a>
        <a class="nav-link mx-2" href="#laporan">Laporan</a>
        <a class="nav-link mx-2" href="#ruangan">Ruangan</a>
        <a class="nav-link mx-2" href="#peminjaman">Peminjaman</a>
    </nav>

    <!-- Dashboard Section -->
    <section id="dashboard" class="mb-5">
        <h4 class="fw-semibold mb-3">Dashboard</h4>
        <p>Halaman utama admin yang menampilkan ringkasan statistik peminjaman, ruangan, dan notifikasi penting. Gunakan dashboard untuk memantau aktivitas sistem secara cepat.</p>
        <ul>
            <li>Lihat total peminjaman, ruangan, dan pengguna aktif.</li>
            <li>Periksa notifikasi atau pemberitahuan penting.</li>
            <li>Akses menu utama ke fitur lain melalui sidebar.</li>
        </ul>
    </section>

    <!-- Laporan Section -->
    <section id="laporan" class="mb-5">
        <h4 class="fw-semibold mb-3">Laporan</h4>
        <p>Menu <b>Laporan</b> digunakan untuk melihat dan mengunduh data peminjaman dalam periode tertentu.</p>
        <ul>
            <li>Pilih rentang tanggal untuk filter laporan.</li>
            <li>Ekspor laporan ke format PDF atau Excel jika diperlukan.</li>
            <li>Gunakan laporan untuk keperluan administrasi atau audit.</li>
        </ul>
    </section>

    <!-- Ruangan Section -->
    <section id="ruangan" class="mb-5">
        <h4 class="fw-semibold mb-3">Ruangan</h4>
        <p>Menu <b>Kelola Ruangan</b> digunakan untuk menambah, mengedit, atau menghapus data ruangan yang tersedia untuk dipinjam.</p>
        <ul>
            <li>Tambah ruangan baru dengan mengisi form detail ruangan.</li>
            <li>Edit data ruangan jika ada perubahan fasilitas, kapasitas, atau gambar.</li>
            <li>Hapus ruangan yang sudah tidak tersedia.</li>
            <li>Pastikan data ruangan selalu up-to-date agar peminjam tidak salah memilih.</li>
        </ul>
    </section>

    <!-- Peminjaman Section -->
    <section id="peminjaman" class="mb-5">
        <h4 class="fw-semibold mb-3">Peminjaman</h4>
        <p>Menu <b>Kelola Peminjaman</b> digunakan untuk memproses permintaan peminjaman ruangan dari pengguna.</p>
        <ul>
            <li>Lihat daftar permohonan peminjaman yang masuk.</li>
            <li>Setujui atau tolak permohonan sesuai ketersediaan dan kebijakan.</li>
            <li>Isi alasan penolakan jika permohonan tidak dapat disetujui.</li>
            <li>Pantau status peminjaman dan lakukan update jika ada perubahan jadwal.</li>
        </ul>
    </section>
</div>

@push('scripts')
<script>
    // Smooth scroll for nav links
    document.querySelectorAll('.nav-link[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if(target) {
                window.scrollTo({
                    top: target.offsetTop - 80, // offset for sticky nav
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
@endpush
@endsection