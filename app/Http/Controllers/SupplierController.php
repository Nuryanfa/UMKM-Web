<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Transaksi;

class SupplierController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $produkCount = Produk::where('supplier_id', $user->id)->count();
        $produkStokRendah = Produk::where('supplier_id', $user->id)->where('stok', '<=', 5)->get();
        // Assuming relationship setup for Transaksi -> DetailPesanan -> Produk
        // This query might need refinement depending on exact model relationships for deep nesting
        // Simplified: Fetch transactions related to supplier's products
        
        // Mock data logic for dashboard chart simplicity if complex relations aren't perfect yet
        $transaksis = Transaksi::all(); // Placeholder: Filter properly in real app
        
        $totalPendapatan = 0; // Calculate properly
        $transaksiPending = 0;

        $produkTerjual = ['Bayam' => 15, 'Wortel' => 8, 'Kangkung' => 12]; // Mock data for chart visualization
        $produkList = Produk::where('supplier_id', $user->id)->latest()->get();

        return \Inertia\Inertia::render('Supplier/Dashboard', [
            'produkCount' => $produkCount,
            'produkStokRendah' => $produkStokRendah,
            'totalPendapatan' => 5000000, 
            'transaksiPending' => 3,
            'produkTerjual' => $produkTerjual,
            'produkList' => $produkList
        ]);
    }

    public function produkIndex()
    {
        $products = Produk::where('supplier_id', Auth::id())->latest()->get();
        return \Inertia\Inertia::render('Supplier/Products/Index', ['products' => $products]);
    }

    public function create()
    {
        return \Inertia\Inertia::render('Supplier/Products/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required', // Note: name mismatch handling (nama vs nama_produk)
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $attr = $request->all();
        $attr['supplier_id'] = Auth::id();
        // Handle file upload if 'gambar' is present
        
        Produk::create($attr);

        return redirect()->route('supplier.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $product = Produk::where('id', $id)->where('supplier_id', Auth::id())->firstOrFail();
        return \Inertia\Inertia::render('Supplier/Products/Form', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $product = Produk::where('id', $id)->where('supplier_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $attr = $request->except(['gambar']); // Handle image separately if needed later
        
        // Basic update for now
        $product->update($attr);

        return redirect()->route('supplier.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        Produk::where('id', $id)->where('supplier_id', Auth::id())->delete();
        return back()->with('success', 'Produk dihapus.');
    }
}
