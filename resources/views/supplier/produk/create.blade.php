@extends('layouts.adminlte')

@section('title', 'Tambah Produk')

@section('content')
<div class="card">
    <div class="card-header">Tambah Produk</div>
    <div class="card-body">
        <form method="POST" action="{{ route('supplier.produk.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" class="form-control">
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
