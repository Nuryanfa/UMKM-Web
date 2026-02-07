@extends('layouts.adminlte')
@section('title', 'Dashboard Supplier')

@section('content')
<div class="container-fluid">

  {{-- Info Box --}}
  <div class="row">
    <div class="col-lg-4 col-12">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $produkCount }}</h3>
          <p>Total Produk Anda</p>
        </div>
        <div class="icon">
          <i class="fas fa-seedling"></i>
        </div>
        <a href="{{ url('/produk/create') }}" class="small-box-footer">Tambah Produk <i class="fas fa-plus-circle"></i></a>
      </div>
    </div>
  </div>

  {{-- Grafik Stok --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Grafik Stok Produk</h3>
        </div>
        <div class="card-body">
          <canvas id="stokChart" style="min-height:300px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Tabel Produk Terbaru --}}
  <div class="card mt-4">
    <div class="card-header">
      <h3 class="card-title">Produk Terbaru</h3>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Kategori</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($produk->sortByDesc('created_at')->take(5) as $item)
            <tr>
              <td>{{ $item->nama }}</td>
              <td>Rp{{ number_format($item->harga) }}</td>
              <td>{{ $item->stok }}</td>
              <td>{{ $item->kategori ?? '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="card mt-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Produk Terbaru Anda</h3>
    <a href="{{ route('produk.create') }}" class="btn btn-sm btn-success">Tambah Produk</a>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($produk->sortByDesc('created_at')->take(5) as $item)
          <tr @if($item->stok < 5) class="table-warning" @endif>
            <td>{{ $item->nama }}</td>
            <td>Rp{{ number_format($item->harga) }}</td>
            <td>{{ $item->stok }}</td>
            <td>{{ $item->kategori ?? '-' }}</td>
            <td>
              <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus produk?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <small class="text-muted">* Baris kuning menandakan stok hampir habis.</small>
  </div>
</div>
@if ($produkStokRendah->count())
  <div class="alert alert-warning mt-4">
    <strong>Perhatian!</strong> Produk berikut hampir habis stoknya:
    <ul class="mb-0">
      @foreach ($produkStokRendah as $item)
        <li>{{ $item->nama }} (stok: {{ $item->stok }})</li>
      @endforeach
    </ul>
  </div>
@endif
<div class="card mt-4">
  <div class="card-header">
    <h3 class="card-title">Riwayat Transaksi Produk Anda</h3>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
          <th>Pelanggan</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($transaksi as $trx)
          <tr>
            <td>{{ $trx->produk->nama ?? '-' }}</td>
            <td>{{ $trx->jumlah }}</td>
            <td>Rp{{ number_format($trx->subtotal) }}</td>
            <td>{{ $trx->pesanan->user->name ?? '-' }}</td>
            <td>
              <span class="badge bg-{{ $trx->pesanan->status == 'selesai' ? 'success' : 'warning' }}">
                {{ $trx->pesanan->status }}
              </span>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>



</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('stokChart').getContext('2d');
const stokChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: {!! json_encode($namaProduk) !!},
    datasets: [{
      label: 'Stok',
      data: {!! json_encode($stokProduk) !!},
      backgroundColor: 'rgba(40, 167, 69, 0.6)',
      borderColor: 'rgba(40, 167, 69, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>
@endsection
