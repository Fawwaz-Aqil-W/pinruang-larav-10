@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
 <!-- Helpdesk Content -->
 <section class="helpdesk-section py-5 mt-5">
  <div class="container">
      <div class="row">
       <!-- Helpdesk untuk Staff -->
        <div class="col-md-6">
          <div class="card shadow-sm h-100 text-center">
            <img src="{{ asset('images/admin.png') }}" class="card-img-top img-fluid img" alt="Helpdesk Staff">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Helpdesk Staff</h5>
              <p class="card-text flex-grow-1">
                Panduan dan bantuan khusus untuk staff dalam menggunakan sistem Si Pinjam.
              </p>
              <a href="#" class="btn btn-primary">Lihat Panduan Staff</a>
            </div>
          </div>
        </div>
      
        <!-- Helpdesk untuk Mahasiswa -->
        <div class="col-md-6">
          <div class="card shadow-sm h-100 text-center">
            <img src="{{ asset('images/student.png') }}" class="card-img-top img-fluid img" alt="Helpdesk Mahasiswa">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Helpdesk Mahasiswa</h5>
              <p class="card-text flex-grow-1">
                Panduan dan bantuan khusus untuk mahasiswa dalam menggunakan sistem Si Pinjam.
              </p>
              <a href="#" class="btn btn-success">Lihat Panduan Mahasiswa</a>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
