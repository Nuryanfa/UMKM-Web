@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($produk) ? 'Edit' : 'Tambah' }} Produk</h2>
    <form method="POST" action="{{ isset($produk) ? route('produk.update', $produk->id) : route('produk.store') }}">
        @csrf
        @if(isset($produk))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk', $produk->nama_produk ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga', $produk->harga ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label>Satuan</label>
            <input type="text" name="satuan" class="form-control" value="{{ old('satuan', $produk->satuan ?? '') }}" required>
        </div>

        <button class="btn btn-primary">{{ isset($produk) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
