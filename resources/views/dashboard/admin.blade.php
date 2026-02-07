@extends('layouts.adminlte')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

  {{-- SECTION: Info Box Statistik --}}
  <div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $supplierCount }}</h3>
          <p>Jumlah Supplier</p>
        </div>
        <div class="icon">
          <i class="fas fa-user-tie"></i>
        </div>
        <a href="/admin/suppliers" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $pelangganCount }}</h3>
          <p>Jumlah Pelanggan</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
        <a href="/admin/pelanggan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $produkCount }}</h3>
          <p>Total Produk</p>
        </div>
        <div class="icon">
          <i class="fas fa-carrot"></i>
        </div>
        <a href="/admin/produk" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $pesananCount }}</h3>
          <p>Total Pesanan</p>
        </div>
        <div class="icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <a href="/admin/pesanan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>

  {{-- SECTION: Grafik Pesanan --}}
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Grafik Pesanan Bulanan</h3>
        </div>
        <div class="card-body">
          <canvas id="pesananChart" style="min-height: 300px; height: 300px;"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
  <div class="card-header">
    <h3 class="card-title">Produk Paling Laku</h3>
  </div>
  <div class="card-body">
    <canvas id="produkPieChart" style="min-height: 300px;"></canvas>
  </div>
</div>
<div class="card mt-4">
  <div class="card-header">
    <h3 class="card-title">Pesanan Terbaru</h3>
  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pesananTerbaru as $pesanan)
          <tr>
            <td>{{ $pesanan->kode_pesanan }}</td>
            <td>{{ $pesanan->user->name ?? '-' }}</td>
            <td>Rp{{ number_format($pesanan->total_harga) }}</td>
            <td><span class="badge bg-{{ $pesanan->status == 'selesai' ? 'success' : 'warning' }}">{{ $pesanan->status }}</span></td>
            <td>{{ $pesanan->tanggal_pesanan }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="card mt-4">
  <div class="card-header">
    <h3 class="card-title">Supplier Terbaru</h3>
  </div>
  <div class="card-body">
    <ul class="list-group">
      @foreach ($suppliersTerbaru as $supplier)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          {{ $supplier->name }}
          <span class="badge bg-info">{{ $supplier->created_at->diffForHumans() }}</span>
        </li>
      @endforeach
    </ul>
  </div>
</div>


</div> <!-- /.container-fluid -->

{{-- Script untuk Chart --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('pesananChart').getContext('2d');
  const pesananChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($bulan) !!},
      datasets: [{
        label: 'Jumlah Pesanan',
        data: {!! json_encode($jumlahPesanan) !!},
        backgroundColor: 'rgba(60,141,188,0.2)',
        borderColor: 'rgba(60,141,188,1)',
        borderWidth: 2,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          labels: {
            color: '#333',
            font: {
              size: 14
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
    const pieCtx = document.getElementById('produkPieChart').getContext('2d');
  new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: {!! json_encode($produkTerlaris->pluck('produk.nama')) !!},
      datasets: [{
        data: {!! json_encode($produkTerlaris->pluck('total')) !!},
        backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6f42c1']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
</script>
@endsection
