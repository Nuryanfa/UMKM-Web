<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Transaksi;
use Inertia\Inertia;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Show checkout page.
     */
    public function checkout()
    {
        $items = Keranjang::with('produk')
                        ->where('user_id', Auth::id())
                        ->get();
        // Filter invalid
        $items = $items->filter(fn($item) => $item->produk !== null && ($item->produk->stok ?? 0) > 0)->values();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = $items->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        // Courier Data from Config
        $couriers = config('shipment.couriers');

        return Inertia::render('Checkout/Index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'couriers' => $couriers,
            'midtransClientKey' => config('midtrans.client_key') // Pass client key to frontend
        ]);
    }

    /**
     * Process Payment (Create Order & Snap Token).
     */
    public function processPayment(CheckoutRequest $request)
    {
        $user = Auth::user();
        $items = Keranjang::with('produk')
                        ->where('user_id', $user->id)
                        ->get()
                        ->filter(fn($item) => $item->produk !== null && ($item->produk->stok ?? 0) >= $item->jumlah);

        if ($items->isEmpty()) {
            return response()->json(['error' => 'Keranjang Anda kosong atau produk tidak valid untuk pembayaran.'], 400);
        }

        $subtotalPrice = $items->sum(fn($item) => $item->jumlah * ($item->produk->harga ?? 0));
        $shippingCost = (float) $request->shipping_cost;
        $totalPrice = $subtotalPrice + $shippingCost;

        $orderId = 'TRX-' . time() . '-' . uniqid();
        $snapToken = null;

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $totalPrice,
        ];

        $itemDetails = [];
        foreach ($items as $item) {
            $itemDetails[] = [
                'id' => $item->produk->id,
                'price' => (float) $item->produk->harga,
                'quantity' => $item->jumlah,
                'name' => $item->produk->nama_produk,
            ];
        }

        if ($shippingCost > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING_FEE',
                'price' => $shippingCost,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman (' . $request->courier_name . ')',
            ];
        }

        $customerDetails = [
            'first_name' => $user->name,
            'email' => $user->email,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('keranjang.index', ['payment_status' => 'success', 'order_id' => $orderId]),
                'error' => route('keranjang.index', ['payment_status' => 'error', 'order_id' => $orderId]),
                'pending' => route('keranjang.index', ['payment_status' => 'pending', 'order_id' => $orderId]),
            ],
        ];

        try {
            DB::transaction(function () use ($orderId, $user, $totalPrice, $params, $items, &$snapToken, $request, $shippingCost) {
                $snapToken = Snap::getSnapToken($params);

                $pesanan = Pesanan::create([
                    'user_id' => $user->id,
                    'kode_pesanan' => 'PSN-' . strtoupper(uniqid()),
                    'alamat_pengiriman' => $request->delivery_address,
                    'total_harga' => $totalPrice,
                    'status' => 'pending',
                ]);

                $transaksi = Transaksi::create([
                    'user_id' => $user->id,
                    'pesanan_id' => $pesanan->id,
                    'kode_transaksi' => $orderId,
                    'total_transaksi' => $totalPrice,
                    'status_transaksi' => 'pending',
                    'nama_kurir' => $request->courier_name,
                    'nomor_telepon_kurir' => '08123456789', // Placeholder
                    'payment_status' => 'pending', 
                ]);

                foreach ($items as $item) {
                    $transaksi->products()->attach($item->produk_id, [
                        'quantity' => $item->jumlah,
                        'price_at_order' => $item->produk->harga,
                    ]);
                }

                Keranjang::where('user_id', $user->id)->delete();
            });

            return response()->json(['snap_token' => $snapToken, 'order_id' => $orderId]);

        } catch (Exception $e) {
            Log::error('Midtrans Transaction Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show Invoice.
     */
    public function showInvoice($orderId)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
                              ->where('kode_transaksi', $orderId)
                              ->with('products')
                              ->firstOrFail();

        return view('customer.invoice', compact('transaksi'));
    }
}
