{{-- resources/views/homepage.blade.php --}}
@extends('layouts.app')

@section('title', 'SayurSehat - Beranda')

@section('content')
{{-- Bagian Selamat Datang (Hero Section) - Fullscreen --}}
<header class="hero-section fullscreen-section">
    <div class="container text-center">
        <h1 class="animated-fade-in">Selamat Datang di Sayur Sehat..!!</h1>
        <p class="lead animated-fade-in-delay">Platform sayuran segar langsung dari petani lokal untuk kebutuhan Anda.</p>
        <a href="{{ route('produk.publik') }}" class="btn btn-success btn-lg animated-fade-in-delay">Jelajahi Produk</a>
    </div>
</header>

{{-- Bagian Mengapa Memilih Kami? - Dengan Jarak Cukup dan 6 Card --}}
<section class="container-fluid py-5 bg-light fullscreen-section">
    <div class="container">
        <h2 class="text-center mb-5 animated-fade-in">Mengapa Memilih Kami?</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
            {{-- Card 1 --}}
            <div class="col reveal-card">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <i class="bi bi-patch-check-fill text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title fw-bold">Kualitas Terjamin</h5>
                        <p class="card-text">Kami hanya menyediakan sayuran segar pilihan terbaik langsung dari sumbernya, memastikan kualitas premium untuk setiap produk.</p>
                    </div>
                </div>
            </div>
            {{-- Card 2 --}}
            <div class="col reveal-card">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <i class="bi bi-truck-flatbed text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title fw-bold">Pengiriman Cepat & Aman</h5>
                        <p class="card-text">Pesanan Anda akan tiba dengan aman dan cepat di depan pintu rumah Anda, siap untuk diolah.</p>
                    </div>
                </div>
            </div>
            {{-- Card 3 --}}
            <div class="col reveal-card">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <i class="bi bi-wallet-fill text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title fw-bold">Harga Terbaik</h5>
                        <p class="card-text">Dapatkan sayuran berkualitas tinggi dengan harga yang sangat bersaing, langsung dari petani tanpa perantara.</p>
                    </div>
                </div>
            </div>
            {{-- Card 4 --}}
            <div class="col reveal-card">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <i class="bi bi-person-fill-check text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title fw-bold">Dukungan Petani Lokal</h5>
                        <p class="card-text">Setiap pembelian Anda berkontribusi langsung pada kesejahteraan petani lokal dan keberlanjutan pertanian.</p>
                    </div>
                </div>
            </div>
            {{-- Card 5 --}}
            <div class="col reveal-card">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <i class="bi bi-basket-fill text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title fw-bold">Pilihan Beragam</h5>
                        <p class="card-text">Kami menyediakan berbagai macam sayuran musiman dan favorit, selalu fresh dan siap kirim.</p>
                    </div>
                </div>
            </div>
            {{-- Card 6 --}}
            <div class="col reveal-card">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <i class="bi bi-chat-dots-fill text-success mb-3" style="font-size: 3rem;"></i>
                        <h5 class="card-title fw-bold">Layanan Pelanggan Responsif</h5>
                        <p class="card-text">Tim kami siap membantu Anda dengan setiap pertanyaan atau kebutuhan, respons cepat dan ramah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Bagian Tertarik Menjadi Pelanggan? - Fullscreen --}}
<section class="fullscreen-section bg-success text-white py-5">
    <div class="container text-center">
        <h2 class="mb-4 animated-fade-in">Tertarik Menjadi Pelanggan Kami?</h2>
        <p class="lead mb-4 animated-fade-in-delay">Daftar sekarang dan nikmati kemudahan berbelanja sayuran segar berkualitas.</p>
        <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill animated-fade-in-delay">Daftar Sekarang!</a>
    </div>
</section>
@endsection
