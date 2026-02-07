<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Inertia\Inertia;
use App\Http\Requests\StoreCartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class CartController extends Controller
{
    /**
     * Display public products (catalog).
     * Moved from KeranjangController@produkPublik
     */

// ...

    /**
     * Display public products (catalog).
     * Moved from KeranjangController@produkPublik
     */
    public function produkPublik()
    {
        $produk = Produk::where('stok', '>', 0)->get();
        // Since we are using Inertia, cart count/items usually passed via shared props (Middleware) or specific props. 
        // For now, let's keep it simple and just return products. MainLayout should handle cart badge if setup properly.
        // But for consistency let's pass it if needed, though MainLayout usually fetches it via shared data if we want global cart count.
        
        return Inertia::render('Products/Index', [
            'produk' => $produk
        ]);
    }

    /**
     * Display the cart contents.
     */
    public function index()
    {
        $items = Keranjang::with('produk')
                        ->where('user_id', Auth::id())
                        ->get();
        
        // Filter out invalid products or zero stock
        $items = $items->filter(fn($item) => $item->produk !== null && ($item->produk->stok ?? 0) > 0)->values();
        
        $total = $items->sum(function ($item) {
            return $item->jumlah * ($item->produk->harga ?? 0);
        });

        // Optional parameters for payment feedback (handled in view)
        $paymentStatus = request()->query('payment_status');
        $orderId = request()->query('order_id');
        
        $latestTransaction = null;
        if ($paymentStatus == 'success' && $orderId) {
            $latestTransaction = \App\Models\Transaksi::where('user_id', Auth::id())
                                        ->where('order_id', $orderId)
                                        ->with('products')
                                        ->first();
        }

        return Inertia::render('Cart/Index', [
            'items' => $items,
            'total' => $total,
            'paymentStatus' => $paymentStatus,
            'orderId' => $orderId,
            'latestTransaction' => $latestTransaction
        ]);
    }

    /**
     * Add item to cart.
     */
    public function store(StoreCartRequest $request, $produkId)
    {
        $userId = Auth::id();
        $produk = Produk::find($produkId);
        
        if (!$produk) {
            return back()->withErrors(['produk' => 'Produk tidak ditemukan.']);
        }
        
        if ($produk->stok <= 0) {
            return back()->withErrors(['produk' => 'Maaf, stok produk ini sudah habis.']);
        }

        $existing = Keranjang::where('user_id', $userId)
                             ->where('produk_id', $produkId)
                             ->first();

        try {
            DB::transaction(function () use ($request, $userId, $produkId, $produk, $existing) {
                if ($existing) {
                    $newJumlah = $existing->jumlah + $request->jumlah;
                    if ($newJumlah > $produk->stok) {
                        throw new Exception('Penambahan jumlah melebihi stok yang tersedia.');
                    }
                    $existing->jumlah = $newJumlah;
                    $existing->save();
                } else {
                    Keranjang::create([
                        'user_id'   => $userId,
                        'produk_id' => $produkId,
                        'jumlah'    => $request->jumlah,
                    ]);
                }
            });
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $item = Keranjang::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->firstOrFail();
                         
        $produk = Produk::find($item->produk_id);
        
        if (!$produk) {
            return back()->withErrors(['produk' => 'Produk tidak ditemukan atau telah dihapus.']);
        }
        
        if ($request->jumlah > $produk->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah beli melebihi stok yang tersedia. (Stok saat ini: ' . $produk->stok . ')']);
        }
        
        $item->jumlah = $request->jumlah;
        $item->save();
        
        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    /**
     * Remove item from cart.
     */
    public function destroy($id)
    {
        Keranjang::where('id', $id)
                 ->where('user_id', Auth::id())
                 ->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
