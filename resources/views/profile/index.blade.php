@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<!-- Notifikasi Section -->
<section id="notifikasi" class="notifications-section py-3">
    <div class="container notification-container">
        @if($notifikasi->count() > 0)
            <a href="#notifikasi" class="position-relative d-inline-block mb-2" id="notif-badge">
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">{{ $notifikasi->count() }}</span>
            </a>
        @endif
        @foreach($notifikasi as $notif)
            <div class="notification d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2a2 2 0 00-2 2v1.268A7.002 7.002 0 005 12v5l-1.447 2.894A1 1 0 004.447 22h15.106a1 1 0 00.894-1.447L19 17v-5a7.002 7.002 0 00-5-6.732V4a2 2 0 00-2-2zM12 24a2 2 0 002-2H10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="content">
                        <p class="title">Notifikasi</p>
                        <p class="message">{{ $notif->pesan }}</p>
                        <a href="{{ route('pinjem.status') }}" class="detail-link">Lihat Detail &#8250;</a>
                    </div>
                </div>
                <form action="{{ route('notifikasi.destroy', $notif->id) }}" method="POST" class="ms-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Notifikasi">&times;</button>
                </form>
            </div>
        @endforeach
    </div>
</section>

<!-- Profile Section -->
<section class="profile-section py-5">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header custom-header">
                <h4>Informasi Profil</h4>
            </div>
            <div class="card-body">
                <!-- Profil Details -->
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Nama:</strong> {{ Auth::user()->name }}</li>
                    <li class="list-group-item"><strong>NIM:</strong> {{ Auth::user()->nim }}</li>
                    <li class="list-group-item"><strong>Jurusan:</strong> {{ auth()->user()->jurusan }}</li>
                    <li class="list-group-item"><strong>Angkatan:</strong> 2023</li>
                </ul>
                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <img src="{{ Auth::user()->foto_url ?? asset('img/default-profile.png') }}" alt="Foto Profil" class="rounded-circle" width="120" height="120">
                    <form action="{{ route('profile.updateFoto') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                        @csrf
                        <input type="file" name="foto" accept="image/*" class="form-control mb-2" style="max-width:200px;display:inline-block;">
                        <button type="submit" class="btn btn-primary btn-sm">Ubah Foto</button>
                    </form>
                </div>
                <!-- Logout Button -->
                <div class="text-center mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection