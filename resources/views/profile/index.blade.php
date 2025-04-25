@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
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