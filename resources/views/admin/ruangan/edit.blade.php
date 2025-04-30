@extends('layouts.admin')

@section('title', 'Edit Ruangan')

@section('content')
<div class="container">
    <h3>Edit Ruangan</h3>
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    <form action="{{ route('admin.ruangan.update', $ruangan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Ruangan</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $ruangan->nama) }}" required>
        </div>
        <div class="mb-3">
            <label>Kode Ruangan</label>
            <input type="text" name="kode_ruangan" class="form-control" value="{{ old('kode_ruangan', $ruangan->kode_ruangan) }}" required>
        </div>
        <div class="mb-3">
            <label>Gedung</label>
            <input type="text" name="gedung" class="form-control" value="{{ old('gedung', $ruangan->gedung) }}" required>
        </div>
        <div class="mb-3">
            <label>Kapasitas</label>
            <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $ruangan->kapasitas) }}" required>
        </div>
        <div class="mb-3">
            <label>Fasilitas</label>
            <input type="text" name="fasilitas" class="form-control" value="{{ old('fasilitas', $ruangan->fasilitas) }}">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $ruangan->deskripsi) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Saat Ini:</label><br>
            @if($ruangan->gambar)
                <img src="{{ asset('storage/'.$ruangan->gambar) }}" width="120">
            @elseif($ruangan->gambar_url)
                <img src="{{ $ruangan->gambar_url }}" width="120">
            @endif
        </div>
        <div class="mb-3">
            <label>Ganti Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <div class="mb-3">
            <label>URL Gambar (opsional)</label>
            <input type="url" name="gambar_url" class="form-control" value="{{ old('gambar_url', $ruangan->gambar_url) }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.ruangan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection