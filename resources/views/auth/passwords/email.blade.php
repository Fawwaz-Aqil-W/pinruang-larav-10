@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="login-container container">
    <div class="login-form-box text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Login Logo" class="login-logo">
        <div class="alert alert-success mt-4">
            Reset password sudah dikirim ke email anda
        </div>
        <a href="{{ route('login') }}" class="btn signin-btn mt-3">Kembali ke Login</a>
    </div>
</div>
@endsection