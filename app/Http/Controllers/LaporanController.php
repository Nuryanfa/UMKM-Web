<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $totalPendapatan = Pesanan::where('status', 'selesai')->sum('total_harga');
        $totalPesanan = Pesanan::count();
        $pesananSelesai = Pesanan::where('status', 'selesai')->count();

        // Statistik bulanan
        $pesananPerBulan = Pesanan::select(
                DB::raw("MONTH(tanggal_pesanan) as bulan"),
                DB::raw("SUM(total_harga) as total")
            )
            ->whereYear('tanggal_pesanan', date('Y'))
            ->groupBy(DB::raw("MONTH(tanggal_pesanan)"))
            ->pluck('total', 'bulan');

        return view('admin.laporan', compact(
            'totalPendapatan',
            'totalPesanan',
            'pesananSelesai',
            'pesananPerBulan'
        ));
    }
}
