@extends('layouts.app')

@section('title', 'Login UMKM Sayuran')

@section('content')
<div class="container-fluid login-register-background d-flex align-items-center justify-content-center py-5">
    <div class="row justify-content-center w-100">
        <div class="col-md-7 col-lg-5 col-xl-4 animate__animated animate__fadeInDown">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden login-register-card">
                <div class="card-body p-4 p-md-5">
                    <h2 class="text-center mb-4 fw-bold text-success">Selamat Datang Kembali!</h2>
                    <p class="text-center text-muted mb-4">Silakan masuk ke akun Anda.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-md-end">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-md-end">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Ingat Saya') }}
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill animate__animated animate__pulse animate__infinite" style="--animate-duration: 2s;">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-decoration-none text-muted" href="{{ route('password.request') }}">
                                    {{ __('Lupa Password Anda?') }}
                                </a>
                            @endif
                            <p class="mt-3 text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Daftar Sekarang</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .login-register-background {
        background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://placehold.co/1920x1080/6CB24C/FFFFFF?text=Sayuran+Segar+Background') center center no-repeat;
        background-size: cover;
        background-attachment: fixed;
        min-height: calc(100vh - var(--navbar-height) - var(--footer-height)); /* Sesuaikan tinggi agar fullscreen */
    }

    .login-register-card {
        background-color: rgba(255, 255, 255, 0.95); /* Sedikit transparan */
        backdrop-filter: blur(5px); /* Efek blur pada background */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .form-control.rounded-pill {
        height: 50px; /* Membuat input lebih tinggi */
        padding-left: 20px;
        padding-right: 20px;
    }

    .btn-success.rounded-pill {
        padding: 12px 25px;
        font-size: 1.1rem;
        font-weight: bold;
        transition: transform 0.2s ease-in-out;
    }

    .btn-success.rounded-pill:hover {
        transform: translateY(-3px);
    }

    /* Override untuk animasi Pulse yang lebih halus */
    .animate__animated.animate__pulse.animate__infinite {
        animation-name: pulse;
        animation-timing-function: ease-in-out;
    }
</style>
@endpush
