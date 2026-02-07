{{-- resources/views/supplier/produk/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow mb-4 animate__animated animate__fadeIn">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Produk</h6>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                @if ($product->gambar)
                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="img-fluid rounded shadow-sm" style="max-width: 250px; max-height: 250px; object-fit: cover;">
                @else
                    <img src="https://placehold.co/250x250/E0E0E0/808080?text=No+Image" alt="No Image" class="img-fluid rounded shadow-sm">
                @endif
            </div>

            <dl class="row mb-0">
                <dt class="col-sm-4 text-muted">Nama Produk:</dt>
                <dd class="col-sm-8">{{ $product->nama_produk }}</dd>

                <dt class="col-sm-4 text-muted">Harga:</dt>
                <dd class="col-sm-8">Rp{{ number_format($product->harga, 0, ',', '.') }}</dd>

                <dt class="col-sm-4 text-muted">Stok:</dt>
                <dd class="col-sm-8">{{ $product->stok }}</dd>

                <dt class="col-sm-4 text-muted">Kategori:</dt>
                <dd class="col-sm-8">{{ $product->kategori ?? '-' }}</dd>

                <dt class="col-sm-4 text-muted">Satuan:</dt>
                <dd class="col-sm-8">{{ $product->satuan ?? '-' }}</dd>
            </dl>

            <h5 class="mt-4 mb-2 text-primary">Deskripsi Produk:</h5>
            <p>{{ $product->deskripsi }}</p>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('supplier.produk.index') }}" class="btn btn-secondary animate__animated animate__fadeInRight">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
