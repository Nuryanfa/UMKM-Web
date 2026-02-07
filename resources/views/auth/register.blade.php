@extends('layouts.app')

@section('title', 'Register UMKM Sayuran')

@section('content')
<div class="container-fluid login-register-background d-flex align-items-center justify-content-center py-5">
    <div class="row justify-content-center w-100">
        <div class="col-md-7 col-lg-5 col-xl-4 animate__animated animate__fadeInUp">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden login-register-card">
                <div class="card-body p-4 p-md-5">
                    <h2 class="text-center mb-4 fw-bold text-success">Daftar Akun Baru!</h2>
                    <p class="text-center text-muted mb-4">Bergabunglah dengan UMKM Sayuran sekarang.</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label text-md-end">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-md-end">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-md-end">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control rounded-pill" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        {{-- Input Role Baru --}}
                        <div class="mb-4">
                            <label class="form-label d-block">{{ __('Daftar Sebagai') }}</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role" id="rolePelanggan" value="pelanggan" {{ old('role') == 'pelanggan' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="rolePelanggan">Pelanggan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role" id="roleSupplier" value="supplier" {{ old('role') == 'supplier' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="roleSupplier">Supplier</label>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block"> {{-- d-block untuk memastikan pesan error tampil --}}
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill animate__animated animate__pulse animate__infinite" style="--animate-duration: 2s;">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mt-3 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Login Sekarang</a></p>
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
