<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Halaman Dashboard
    public function index()
    {
        // Statistik Pesanan Bulanan
        // Note: Using MySQL specific function MONTH(). 
        // For PostgreSQL use EXTRACT(MONTH FROM created_at).
        // For SQLite use strftime('%m', created_at).
        $pesanan = Pesanan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y')) // Filter tahun ini agar relevan
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $jumlahPesanan = [];

        // Inisialisasi array untuk 12 bulan agar grafik tidak bolong
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $bulan[] = $monthName;
            
            // Cari data pesanan untuk bulan ini
            $found = $pesanan->firstWhere('bulan', $i);
            $jumlahPesanan[] = $found ? $found->total : 0;
        }

        // Produk paling laku (top 5)
        $produkTerlaris = DetailPesanan::select('produk_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('produk_id')
            ->orderByDesc('total')
            ->with('produk') // pastikan ada relasi ke model Produk
            ->take(5)
            ->get();

        // Supplier terbaru (top 5)
        $suppliersTerbaru = User::where('role', 'supplier')
            ->latest() // Mengambil yang terbaru berdasarkan created_at
            ->take(5)
            ->get();

        // Pesanan terbaru (top 5)
        $pesananTerbaru = Pesanan::with('user') // Memuat relasi user untuk menampilkan nama user
            ->latest() // Mengambil yang terbaru berdasarkan created_at
            ->take(5)
            ->get();

        // Mengirimkan data yang diperlukan ke view dashboard admin
        // Mengirimkan data yang diperlukan ke view dashboard admin
        return \Inertia\Inertia::render('Admin/Dashboard', [
            'supplierCount'    => User::where('role', 'supplier')->count(), // Menghitung jumlah supplier
            'pelangganCount'   => User::where('role', 'pelanggan')->count(), // Menghitung jumlah pelanggan
            'produkCount'      => Produk::count(), // Menghitung jumlah produk
            'pesananCount'     => Pesanan::count(), // Menghitung jumlah total pesanan
            'bulan'            => $bulan, // Data bulan untuk grafik
            'jumlahPesanan'    => $jumlahPesanan, // Data jumlah pesanan untuk grafik
            'produkTerlaris'   => $produkTerlaris, // Data produk terlaris
            'suppliersTerbaru' => $suppliersTerbaru, // Data supplier terbaru
            'pesananTerbaru'   => $pesananTerbaru, // Data pesanan terbaru
        ]);
    }

    // Menampilkan daftar supplier yang statusnya 'pending'
    public function listSuppliers()
    {
        $suppliers = User::where('role', 'supplier')
                            ->where('status_akun', 'pending')
                            ->latest()
                            ->get();

        return \Inertia\Inertia::render('Admin/Suppliers/Index', [
            'suppliers' => $suppliers
        ]);
    }

    // Menyetujui akun supplier
    public function approveSupplier($id)
    {
        $supplier = User::findOrFail($id); 
        $supplier->status_akun = 'aktif'; 
        $supplier->save(); 

        return back()->with('success', 'Akun supplier telah disetujui.'); 
    }

    // Menolak akun supplier
    public function rejectSupplier($id)
    {
        $supplier = User::findOrFail($id); 
        $supplier->status_akun = 'nonaktif'; 
        $supplier->save(); 

        return back()->with('error', 'Akun supplier ditolak.'); 
    }

    // Menampilkan daftar pesanan untuk admin
    public function pesanan()
    {
        $pesanan = Pesanan::with('user')->latest()->get(); 
        
        return \Inertia\Inertia::render('Admin/Orders/Index', [
            'orders' => $pesanan
        ]);
    }

    // Mengubah status pesanan
    public function ubahStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $pesanan = Pesanan::findOrFail($id); 
        $pesanan->status = $request->status; 
        $pesanan->save(); 

        return back()->with('success', 'Status pesanan diperbarui.'); 
    }
}
