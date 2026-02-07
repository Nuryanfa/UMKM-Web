{{-- resources/views/supplier/produk/index.blade.php --}}

@extends('layouts.app') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="h3 mb-0 text-gray-800">Daftar Produk Anda</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('supplier.produk.create') }}" class="btn btn-primary shadow-sm animate__animated animate__fadeInRight">
                <i class="bi bi-plus-circle me-2"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn mb-4" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($products->isEmpty())
        <div class="card shadow mb-4 animate__animated animate__fadeIn">
            <div class="card-body text-center py-5">
                <p class="lead text-muted mb-0">Anda belum memiliki produk apapun.</p>
                <p class="lead text-muted">Mari <a href="{{ route('supplier.produk.create') }}" class="text-primary text-decoration-none">tambah yang pertama</a>!</p>
            </div>
        </div>
    @else
        <div class="card shadow mb-4 animate__animated animate__fadeIn">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($product->gambar)
                                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="img-fluid rounded" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                        @else
                                            <img src="https://placehold.co/80x80/E0E0E0/808080?text=No+Image" alt="No Image" class="img-fluid rounded">
                                        @endif
                                    </td>
                                    <td>{{ $product->nama_produk }}</td>
                                    <td>Rp{{ number_format($product->harga, 0, ',', '.') }}</td>
                                    <td>{{ $product->stok }}</td>
                                    <td>
                                        <a href="{{ route('supplier.produk.show', $product->id) }}" class="btn btn-info btn-sm me-2 animate__animated animate__fadeIn">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('supplier.produk.edit', $product->id) }}" class="btn btn-warning btn-sm me-2 animate__animated animate__fadeIn">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('supplier.produk.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm animate__animated animate__fadeIn">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination Links --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $products->links('pagination::bootstrap-5') }} {{-- Pastikan menggunakan Bootstrap 5 pagination theme --}}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
