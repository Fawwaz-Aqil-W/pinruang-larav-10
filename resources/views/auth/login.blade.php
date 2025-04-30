@extends('layouts.auth')
@section('title', 'login')


@section('content')
<div class="login-container container">
    <div class="login-form-box">
        <img src="{{ asset('images/logo.png') }}" alt="Login Logo" class="login-logo">
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" 
                   class="input-box @error('nim') is-invalid @enderror" 
                   name="nim" 
                   value="{{ old('nim') }}" 
                   placeholder="NIM"
                   required>
            
            <input type="password" 
                   class="input-box @error('password') is-invalid @enderror" 
                   name="password" 
                   placeholder="Password"
                   required>
            
            @error('nim')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            
            <button type="submit" class="signin-btn">Login</button>
        </form>

        <div class="extra-links">
            <a href="{{ route('register') }}">Register</a> |
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>
    </div>
</div>
@endsection