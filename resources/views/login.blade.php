<?php
@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="header">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" />
    <div class="title">Selamat Datang di Si Pinjam</div>
</div>

<div class="login-container">
    <div class="login-form-box">
        <img src="{{ asset('images/logo.png') }}" alt="Login Logo" class="login-logo" />
    
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" class="input-box" placeholder="NIM" name="nim" required />
            <input type="password" class="input-box" placeholder="Password" name="password" required />
            <button type="submit" class="signin-btn">Sign In</button>
        </form>

        <div class="extra-links">
            <a href="{{ route('register') }}">Register</a> |
            <a href="#">Forgot Password?</a>
        </div>
    </div>
</div>
@endsection