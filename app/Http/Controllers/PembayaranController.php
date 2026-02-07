<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Midtrans\Config;
use Midtrans\Notification;

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Handle Midtrans Notification Callback.
     */
    public function callback(Request $request)
    {
        $notif = new Notification();

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;
        $statusCode = $notif->status_code;

        $transaksi = Transaksi::where('kode_transaksi', $orderId)
                              ->orWhere('order_id', $orderId) // Handle potential column name difference
                              ->first();

        if (!$transaksi) {
            // Fallback check if order_id was used as unique key
            Log::warning('Midtrans Callback: Transaksi tidak ditemukan untuk Order ID: ' . $orderId);
            return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        if ($transaksi->payment_status !== 'pending' && $transaksi->payment_status !== 'challenge') {
            Log::info('Midtrans Callback: Transaksi sudah diproses sebelumnya untuk Order ID: ' . $orderId);
            return response()->json(['status' => 'ok', 'message' => 'Transaksi sudah diproses sebelumnya']);
        }

        try {
            DB::transaction(function () use ($transaksi, $transactionStatus, $fraudStatus, $statusCode, $notif) {
                $paymentStatus = 'pending';

                if ($transactionStatus == 'capture') {
                    $paymentStatus = $fraudStatus == 'challenge' ? 'challenge' : 'success';
                } elseif ($transactionStatus == 'settlement') {
                    $paymentStatus = 'success';
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $paymentStatus = 'failed';
                } elseif ($transactionStatus == 'pending') {
                    $paymentStatus = 'pending';
                } elseif (in_array($transactionStatus, ['refund', 'partial_refund'])) {
                    $paymentStatus = 'refunded';
                }

                $transaksi->update([
                    'payment_status' => $paymentStatus,
                    'transaction_id' => $notif->transaction_id,
                    'payment_method' => $notif->payment_type,
                    'status_code' => $statusCode,
                    'raw_response' => json_encode($notif),
                ]);

                if ($paymentStatus == 'success') {
                    foreach ($transaksi->products as $product) {
                        $newStok = $product->stok - $product->pivot->quantity;
                        $product->stok = max(0, $newStok);
                        $product->save();
                    }
                }
            });
            return response()->json(['status' => 'ok', 'message' => 'Notification processed successfully']);
        } catch (Exception $e) {
            Log::error('Midtrans Callback Processing Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
