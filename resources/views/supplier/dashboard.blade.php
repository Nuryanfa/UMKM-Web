@extends('layouts.adminlte')

@section('content')
<div class="container">
    <h2>Dashboard Supplier</h2>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-3"><div class="card"><div class="card-body text-center"><h5>Total Produk</h5><h3>{{ $produkCount }}</h3></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body text-center"><h5>Total Pendapatan</h5><h3>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h3></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body text-center"><h5>Transaksi Pending</h5><h3>{{ $transaksiPending }}</h3></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body text-center"><h5>Produk Stok Rendah</h5><h3>{{ $produkStokRendah->count() }}</h3></div></div></div>
    </div>

    <!-- Chart Produk Terjual -->
    <div class="card mt-4">
        <div class="card-header">Chart Produk Terjual</div>
        <div class="card-body">
            <canvas id="produkChart"></canvas>
        </div>
    </div>

    <!-- Tabel Produk -->
    <div class="card mt-4">
        <div class="card-header">Tabel Produk</div>
        <div class="card-body">
            <table class="table table-bordered" id="produkTable">
                <thead><tr><th>Nama</th><th>Harga</th><th>Stok</th><th>Kategori</th></tr></thead>
                <tbody>
                    @foreach($produkList as $produk)
                        <tr>
                            <td>{{ $produk->nama }}</td>
                            <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>{{ $produk->kategori }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('produkChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($produkTerjual)) !!},
            datasets: [{
                label: 'Jumlah Terjual',
                data: {!! json_encode(array_values($produkTerjual)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection
