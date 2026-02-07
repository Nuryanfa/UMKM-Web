@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Produk Saya</h2>
    <a href="{{ route('produk.create') }}" class="btn btn-success mb-3">+ Tambah Produk</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produk as $p)
                <tr>
                    <td>{{ $p->nama_produk }}</td>
                    <td>Rp {{ number_format($p->harga) }}</td>
                    <td>{{ $p->stok }} {{ $p->satuan }}</td>
                    <td>
                        <a href="{{ route('produk.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="{{ route('produk.destroy', $p->id) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
