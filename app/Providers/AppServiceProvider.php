<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\UiServiceProvider; // <- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind filesystem
        $this->app->bind('files', fn () => new Filesystem());

        // Register UiServiceProvider secara manual
        $this->app->register(UiServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::get('/dashboard', function () {
            $user = Auth::user();

            return match ($user->role) {
                'admin'     => redirect('/admin/dashboard'),
                'supplier'  => redirect('/supplier/dashboard'),
                'pelanggan' => redirect('/home'),
                default     => abort(403, 'Role tidak dikenali'),
            };
        });
    }
}
