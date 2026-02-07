{{-- resources/views/customer/invoice.blade.php --}}
@extends('layouts.app')

@section('title', 'Invoice Pembayaran #' . $transaksi->order_id)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-lg-5">
                    <div class="text-center mb-5">
                        <h1 class="display-5 fw-bold text-success mb-3">Invoice Pembayaran</h1>
                        <p class="lead text-muted">Detail lengkap transaksi Anda.</p>
                    </div>

                    {{-- Informasi Transaksi Utama --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong class="text-primary">Order ID:</strong> #{{ $transaksi->order_id }}</p>
                            <p class="mb-1"><strong class="text-primary">Tanggal Transaksi:</strong> {{ $transaksi->created_at->format('d M Y, H:i') }}</p>
                            <p class="mb-1"><strong class="text-primary">Status Pembayaran:</strong> 
                                <span class="badge bg-{{ 
                                    $transaksi->payment_status == 'success' ? 'success' : 
                                    ($transaksi->payment_status == 'pending' ? 'warning' : 'danger') 
                                }} fs-6">{{ ucfirst($transaksi->payment_status) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong class="text-primary">Nama Pelanggan:</strong> {{ $transaksi->user->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong class="text-primary">Email Pelanggan:</strong> {{ $transaksi->user->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong class="text-primary">Metode Pembayaran:</strong> {{ $transaksi->payment_method ?? 'Belum Diketahui' }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Detail Produk --}}
                    <h5 class="fw-bold mb-3">Produk yang Dibeli</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi->products as $product)
                                    <tr>
                                        <td>{{ $product->nama_produk ?? 'Produk Dihapus' }}</td>
                                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                                        <td class="text-end">Rp{{ number_format($product->pivot->price_at_order, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp{{ number_format($product->pivot->quantity * $product->pivot->price_at_order, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Ringkasan Biaya --}}
                    <div class="row justify-content-end">
                        <div class="col-md-7 col-lg-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-bottom">
                                    <span>Total Produk:</span>
                                    <span class="fw-bold">Rp{{ number_format($transaksi->total_price - ($transaksi->shipping_cost ?? 0), 0, ',', '.') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-bottom">
                                    <span>Biaya Pengiriman ({{ $transaksi->courier_name ?? 'N/A' }}):</span>
                                    <span class="fw-bold">Rp{{ number_format($transaksi->shipping_cost ?? 0, 0, ',', '.') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-0 pt-3">
                                    <span class="fw-bold fs-4 text-primary">Total Pembayaran:</span>
                                    <span class="fw-bold fs-4 text-primary">Rp{{ number_format($transaksi->total_price, 0, ',', '.') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Alamat Pengiriman --}}
                    <h5 class="fw-bold mb-3">Alamat Pengiriman</h5>
                    <p class="text-muted">{{ $transaksi->delivery_address ?? 'Alamat tidak tersedia.' }}</p>

                    <div class="text-center mt-5">
                        <a href="{{ route('produk.publik') }}" class="btn btn-success btn-lg rounded-pill px-4 me-3">
                            <i class="bi bi-shop me-2"></i> Lanjutkan Belanja
                        </a>
                        <button class="btn btn-outline-secondary btn-lg rounded-pill px-4" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i> Cetak Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
