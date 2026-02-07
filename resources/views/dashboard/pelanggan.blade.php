@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard Pelanggan</h2>
    <div class="alert alert-primary">Selamat datang, {{ auth()->user()->nama }}!</div>

    <ul class="list-group mt-4">
        <li class="list-group-item"><a href="/produk">Belanja Produk</a></li>
        <li class="list-group-item"><a href="/keranjang">Keranjang Belanja</a></li>
        <li class="list-group-item"><a href="/riwayat-pesanan">Riwayat Pemesanan</a></li>
    </ul>
</div>
@endsection
