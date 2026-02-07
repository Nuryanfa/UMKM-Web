<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Biarkan ini jika Anda ingin fitur verifikasi email di masa depan
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // BARIS INI DIHAPUS/DIKOMENTARI

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    // use HasApiTokens; // BARIS INI DIHAPUS/DIKOMENTARI

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telepon',       // Kolom kustom Anda
        'alamat',        // Kolom kustom Anda
        'role',          // Kolom kustom Anda
        'status_akun',   // Kolom kustom Anda
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the products for the user (if user is a supplier).
     */
    public function produks()
    {
        return $this->hasMany(Produk::class, 'supplier_id');
    }

    /**
     * Check if the user has the 'admin' role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user has the 'supplier' role.
     */
    public function isSupplier(): bool
    {
        return $this->role === 'supplier';
    }

    /**
     * Check if the user has the 'pelanggan' role.
     */
    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }
}
