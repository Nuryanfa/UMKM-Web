@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan Transaksi</h2>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 bg-success text-white">
                <h5>Total Pendapatan</h5>
                <h3>Rp {{ number_format($totalPendapatan) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-primary text-white">
                <h5>Total Pesanan</h5>
                <h3>{{ $totalPesanan }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-info text-white">
                <h5>Pesanan Selesai</h5>
                <h3>{{ $pesananSelesai }}</h3>
            </div>
        </div>
    </div>

    <h4>Statistik Pesanan per Bulan ({{ date('Y') }})</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach(range(1,12) as $bulan)
                <tr>
                    <td>{{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</td>
                    <td>Rp {{ number_format($pesananPerBulan[$bulan] ?? 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
