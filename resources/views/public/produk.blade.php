{{-- resources/views/public/produk.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">📦 Produk Tersedia di Etalase</h2>

    {{-- Notifikasi: Success dan Error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tombol Lihat Keranjang --}}
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ url('/keranjang') }}" class="btn btn-info btn-lg shadow-sm d-flex align-items-center rounded-pill px-4 py-2">
            🛒 Lihat Keranjang Anda 
            @if (Auth::check() && $items->count() > 0)
                <span class="badge bg-danger ms-2 rounded-pill fs-6">{{ $items->sum('jumlah') }}</span>
            @endif
        </a>
    </div>

    @if ($produk->isEmpty())
        {{-- Pesan jika tidak ada produk --}}
        <div class="alert alert-warning text-center fs-5 py-4 shadow-sm rounded-4" role="alert">
            <h3>Saat ini tidak ada produk yang tersedia.</h3>
            <p class="mb-0">Silakan cek kembali nanti atau hubungi admin.</p>
        </div>
    @else
        {{-- Tampilan Grid Produk (Etalase) --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            {{-- Loop melalui setiap produk dan tampilkan sebagai kartu --}}
            @foreach ($produk as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden transform-on-hover">
                        {{-- Gambar Produk: Menggunakan $item->gambar jika ada, fallback ke placeholder --}}
                        {{-- Pastikan jalur gambar di database Anda sudah benar (misal: 'image/tomat.jpg') --}}
                        <img src="{{ asset($item->gambar_produk ?? 'https://placehold.co/600x400/98DDCA/4A4E69?text=Gambar+Tidak+Tersedia') }}" 
                            class="card-img-top img-fluid" alt="{{ $item->nama_produk ?? 'Produk' }}" 
                            onerror="this.onerror=null;this.src='https://placehold.co/600x400/98DDCA/4A4E69?text=Gambar+Rusak';">

                        <div class="card-body d-flex flex-column">
                            {{-- Nama Produk --}}
                            <h5 class="card-title fw-bold text-primary mb-2">{{ $item->nama_produk ?? 'Nama Produk Tidak Tersedia' }}</h5>
                            
                            {{-- Deskripsi Singkat Produk --}}
                            <p class="card-text text-muted small mb-3 flex-grow-1">
                                {{ Str::limit($item->deskripsi ?? 'Deskripsi produk belum tersedia.', 100) }}
                                @if (strlen($item->deskripsi ?? '') > 100)
                                    {{-- Opsional: Link untuk melihat deskripsi lengkap --}}
                                    <a href="#" class="text-decoration-none">Baca Selengkapnya</a> 
                                @endif
                            </p>
                            
                            {{-- Detail Stok dan Harga --}}
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-0">
                                    <span class="fw-bold text-secondary">Stok:</span>
                                    <span class="badge bg-{{ ($item->stok ?? 0) > 0 ? 'success' : 'danger' }} rounded-pill fs-6 px-3 py-2">
                                        {{ $item->stok ?? 0 }} {{ $item->satuan ?? 'unit' }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-0">
                                    <span class="fw-bold text-secondary">Harga:</span>
                                    <span class="fs-5 text-success fw-bold">Rp{{ number_format($item->harga ?? 0, 0, ',', '.') }}</span>
                                </li>
                            </ul>

                            {{-- Form untuk Menambah ke Keranjang --}}
                            <form action="{{ url('/keranjang/tambah/' . ($item->id ?? '')) }}" method="POST" class="mt-auto">
                                @csrf
                                <div class="input-group mb-2">
                                    {{-- Input Jumlah Beli --}}
                                    <input type="number" name="jumlah" class="form-control form-control-sm text-center rounded-start-pill" 
                                           value="1" min="1" max="{{ $item->stok ?? 1 }}" required 
                                           aria-label="Jumlah beli" placeholder="Jumlah">
                                    
                                    {{-- Tombol Tambahkan ke Keranjang --}}
                                    <button type="submit" class="btn btn-primary btn-sm px-4 rounded-end-pill hover-scale" 
                                            @if (($item->stok ?? 0) <= 0) disabled @endif>
                                        <i class="bi bi-cart-plus me-1"></i> Tambahkan
                                    </button>
                                </div>
                                {{-- Pesan Stok Habis --}}
                                @if (($item->stok ?? 0) <= 0)
                                    <small class="text-danger d-block mt-1 text-center fw-bold">Stok Habis!</small>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
    {{-- Gaya kustom untuk efek hover pada kartu dan tombol --}}
    <style>
        .transform-on-hover {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .transform-on-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .hover-scale {
            transition: transform 0.15s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .btn-info {
            background-color: #17a2b8; /* Warna default Bootstrap info */
            border-color: #17a2b8;
            color: white;
        }
        .btn-info:hover {
            background-color: #138496; /* Warna info sedikit lebih gelap saat hover */
            border-color: #117a8b;
        }
        /* Style untuk gambar produk di card */
        .card-img-top {
            width: 100%;
            height: 200px; /* Tinggi tetap untuk gambar, sesuaikan jika perlu */
            object-fit: cover; /* Memastikan gambar mengisi area tanpa distorsi */
            object-position: center; /* Memastikan cropping selalu dari tengah */
            border-bottom: 1px solid #f0f0f0;
            border-top-left-radius: calc(1rem - 1px); /* Menyesuaikan radius sudut kartu */
            border-top-right-radius: calc(1rem - 1px); /* Menyesuaikan radius sudut kartu */
        }
    </style>
@endpush

@push('scripts')
    {{-- Memastikan Bootstrap JS dimuat untuk fungsionalitas alert dismiss --}}
    {{-- Jika sudah dimuat di layouts.app, bagian ini bisa dihilangkan --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
