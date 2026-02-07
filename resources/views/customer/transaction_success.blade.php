{{-- resources/views/customer/transaction_success.blade.php --}}
@extends('layouts.app') {{-- Pastikan tidak ada spasi atau karakter tambahan setelah 'layouts.app' --}}

@section('title', 'Transaksi Berhasil & Invoice')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm rounded-4 border-0 mb-4">
                <div class="card-body p-lg-4 text-center">
                    <h2 class="mb-4 text-success fw-bold">🎉 Transaksi Berhasil!</h2>
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    <p class="lead mt-3">Terima kasih telah berbelanja di UMKM Sayuran. Pembayaran Anda telah diterima.</p>
                </div>
            </div>

            @if ($transaksi)
            <div class="card shadow-sm rounded-4 border-0 mb-4">
                <div class="card-body p-lg-4">
                    <h5 class="card-title fw-bold mb-3">Detail Pesanan #{{ $transaksi->order_id }}</h5>
                    <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->created_at->format('d F Y H:i') }}</p>
                    <p><strong>Status Pembayaran:</strong> 
                        <span class="badge 
                            @if($transaksi->payment_status == 'success') bg-success
                            @elseif($transaksi->payment_status == 'pending') bg-warning text-dark
                            @elseif($transaksi->payment_status == 'failed') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($transaksi->payment_status) }}
                        </span>
                    </p>
                    <p><strong>Metode Pembayaran:</strong> {{ $transaksi->payment_method ? ucfirst(str_replace('_', ' ', $transaksi->payment_method)) : 'N/A' }}</p>

                    <h6 class="fw-bold mt-4 mb-2">Item Pembelian:</h6>
                    <ul class="list-group list-group-flush mb-3">
                        @php
                            $subtotalItems = 0;
                        @endphp
                        @foreach ($transaksi->products as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent py-2">
                                <span>{{ $product->pivot->quantity }} x {{ $product->nama_produk }}</span>
                                <span>Rp{{ number_format($product->pivot->quantity * $product->pivot->price_at_order, 0, ',', '.') }}</span>
                                @php
                                    $subtotalItems += $product->pivot->quantity * $product->pivot->price_at_order;
                                @endphp
                            </li>
                        @endforeach
                    </ul>

                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-top pt-2">
                            <span>Subtotal Produk</span>
                            <span class="fw-bold">Rp{{ number_format($subtotalItems, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent py-2">
                            <span>Biaya Pengiriman ({{ $transaksi->courier_name ?? 'N/A' }})</span>
                            <span class="fw-bold">Rp{{ number_format($transaksi->shipping_cost ?? 0, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent border-top pt-3">
                            <span class="fw-bold fs-5 text-primary">Total Pembayaran</span>
                            <span class="fw-bold fs-5 text-primary">Rp{{ number_format($transaksi->total_price, 0, ',', '.') }}</span>
                        </li>
                    </ul>

                    <h6 class="fw-bold mt-4 mb-2">Alamat Pengiriman:</h6>
                    <p>{{ $transaksi->delivery_address }}</p>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('customer.riwayat') }}" class="btn btn-primary rounded-pill">Lihat Riwayat Pesanan</a>
                        <a href="{{ route('produk.publik') }}" class="btn btn-outline-secondary rounded-pill">Lanjutkan Belanja</a>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning text-center fs-5 py-4 shadow-sm rounded-4" role="alert">
                <p class="mb-0">Detail transaksi tidak dapat ditemukan.</p>
                <a href="{{ route('keranjang.index') }}" class="btn btn-primary mt-3">Kembali ke Keranjang</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
