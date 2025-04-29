@extends('layouts.app')

@section('title', 'Detail Ruangan')

@section('content')
<div class="home-container">
    <div class="home-content">
        <h1>Daftar Ruangan</h1>
        <p>Pesan Ruang dengan Lebih Mudah! Kami menyediakan solusi praktis untuk mahasiswa dan staf universitas.</p>

        <div class="d-flex flex-wrap gap-4 justify-content-center mt-4">
            @foreach($ruangan as $r)
            <div class="card shadow-sm" style="width: 280px;">
                <a href="{{ route('ruangan.show', $r->kode_ruangan) }}">
                    <img src="{{ $r->gambar_url 
    ?? ($r->gambar ? asset('storage/'.$r->gambar) : asset('images/foto2.png')) }}"
     class="card-img-top"
     alt="{{ $r->nama }}"
     style="border-radius: 6px;">
                </a>
                <div class="card-body">
                    <h4 class="card-title">{{ $r->nama }}</h4>
                    <p class="card-text">Gedung: {{ $r->gedung }}</p>
                    <p class="card-text">Kapasitas: {{ $r->kapasitas }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection