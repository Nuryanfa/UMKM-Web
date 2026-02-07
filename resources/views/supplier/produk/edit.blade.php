{{-- resources/views/supplier/produk/edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow mb-4 animate__animated animate__fadeIn">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Produk: {{ $product->nama_produk }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('supplier.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH') {{-- Atau PUT --}}

                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk:</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                    @error('nama_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga (Rp):</label>
                    <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $product->harga) }}" min="0" step="1" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok:</label>
                    <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $product->stok) }}" min="0" step="1" required>
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori:</label>
                    <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $product->kategori) }}">
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="satuan" class="form-label">Satuan (contoh: ikat, kg, lusin):</label>
                    <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" value="{{ old('satuan', $product->satuan) }}">
                    @error('satuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label">Gambar Produk (Biarkan kosong jika tidak ingin mengubah):</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" class="form-control @error('gambar') is-invalid @enderror">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($product->gambar)
                        <div class="mt-2">
                            <p class="text-muted mb-1">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="img-fluid rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('supplier.produk.index') }}" class="btn btn-secondary animate__animated animate__fadeInLeft">Batal</a>
                    <button type="submit" class="btn btn-primary animate__animated animate__fadeInRight">Perbarui Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
