<?php

namespace App\Http\Controllers;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return view('pelanggan.dashboard');
    }
    public function riwayat()
{
    $pesanan = Pesanan::with('detailPesanan.produk')
                ->where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->get();

    return view('pelanggan.riwayat', compact('pesanan'));
}
}
