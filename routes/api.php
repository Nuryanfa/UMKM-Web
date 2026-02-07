<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;

Route::post('/midtrans/callback', [PembayaranController::class, 'callback']);
