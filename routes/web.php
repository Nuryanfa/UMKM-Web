<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PembayaranController;

// Auth::routes(); // Removing duplicate Auth::routes() if present in other places, but assuming it's needed here. Or just leave it.
Auth::routes();

// === Redirect setelah login berdasarkan role ===
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user) {
        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'supplier' => redirect('/supplier/dashboard'),
            'pelanggan' => app(App\Http\Controllers\CustomerController::class)->dashboard(),
            default => abort(403, 'Role pengguna tidak dikenal.'),
        };
    }

    return redirect('/login');
})->middleware('auth')->name('dashboard.redirect');

// === ADMIN ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/suppliers', [AdminController::class, 'listSuppliers'])->name('admin.suppliers');
    Route::post('/suppliers/{id}/approve', [AdminController::class, 'approveSupplier'])->name('admin.suppliers.approve');
    Route::post('/suppliers/{id}/reject', [AdminController::class, 'rejectSupplier'])->name('admin.suppliers.reject');
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
    Route::post('/pesanan/{id}/status', [AdminController::class, 'ubahStatus'])->name('admin.pesanan.ubahStatus');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
});

// === SUPPLIER ===
Route::middleware(['auth', 'role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [SupplierController::class, 'index'])->name('dashboard');

    // CRUD Produk untuk Supplier
    Route::get('/produk', [SupplierController::class, 'produkIndex'])->name('produk.index');
    Route::get('/produk/create', [SupplierController::class, 'create'])->name('produk.create');
    Route::post('/produk', [SupplierController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}', [SupplierController::class, 'show'])->name('produk.show');
    Route::get('/produk/{id}/edit', [SupplierController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [SupplierController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [SupplierController::class, 'destroy'])->name('produk.destroy');
});

// === PELANGGAN ===
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [CartController::class, 'produkPublik'])->name('home');
    
    // Cart Routes
    Route::post('/keranjang/tambah/{produkId}', [CartController::class, 'store'])->name('keranjang.tambah');
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::patch('/keranjang/{id}', [CartController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('keranjang.hapus');

    // Checkout Routes
    // Note: Keeping '/pembayaran' URL for backward compatibility if useful, or switch to '/checkout'
    Route::get('/pembayaran', [CheckoutController::class, 'checkout'])->name('keranjang.checkout'); 
    Route::post('/pembayaran/proses', [CheckoutController::class, 'processPayment'])->name('keranjang.processPayment');
    
    // Callback (web route) - Keeping consistent with previous logic, though API is preferred
    Route::post('/pembayaran/callback', [PembayaranController::class, 'callback'])->name('keranjang.callback');

    Route::get('/invoice/{orderId}', [CheckoutController::class, 'showInvoice'])->name('keranjang.invoice');
});

// === Halaman Publik ===
use Inertia\Inertia;

// ...

Route::get('/', fn() => Inertia::render('Home'));
Route::get('/produk-publik', [CartController::class, 'produkPublik'])->name('produk.publik');
Route::get('/tentang-kami', fn() => Inertia::render('About'));
Route::get('/kontak', fn() => view('public.kontak'));
