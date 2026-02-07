<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $orders = Transaksi::where('user_id', Auth::id())
                    ->with('products') // Assuming relationship is defined in Transaksi model, otherwise might need adjustment
                    ->latest()
                    ->get();
                    
        return Inertia::render('Customer/Dashboard', [
            'orders' => $orders
        ]);
    }
}
