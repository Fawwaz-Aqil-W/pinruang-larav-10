@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!--Hero Section-->
<section class="hero-slideshow text-white text-center pt-0 pb-5">
    <div class="container">
        <h2 class="mb-3 ">Selamat Datang di Si Pinjam</h2>
        <p class="lead">Layanan terpadu untuk mempermudah proses peminjaman fasilitas kampus FT secara efisien.</p>
    </div>
</section>

<!-- Cek Tanggal Section -->
<section class="date-checker-section py-4 bg-white">
    <div class="container">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <div class="date-checker bg-light p-4 rounded shadow-sm">
                <form action="{{ route('ruangan.check') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="start-date" class="form-label">Tanggal Awal</label>
                        <input type="date" id="start-date" name="start_date" class="form-control" required />
                    </div>
                    <div class="col-md-4">
                        <label for="end-date" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="end-date" name="end_date" class="form-control" required />
                    </div>
                    <div class="col-md-3">
                        <label for="building" class="form-label">Gedung</label>
                        <select id="building" name="building" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Gedung --</option>
                            <option value="gedung-a">Aula FT</option>
                            <option value="gedung-b">Auditorium FT</option>
                            <option value="gedung-c">Vicon FT</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="signin-btn">Check</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const heroSection = document.querySelector('.hero-slideshow');
    const images = [
        "images/foto2.png",
        "images/foto1.png",
    ];

    let index = 0;

    function changeBackground() {
        heroSection.style.backgroundImage = `url(${images[index]})`;
        index = (index + 1) % images.length;
    }

    changeBackground();
    setInterval(changeBackground, 4000);
</script>
@endsection