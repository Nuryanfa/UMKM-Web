<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'supplier_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar_produk', // Pastikan kolom ini ada di database
    ];

    /**
     * Relasi dengan model User (Supplier)
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    /**
     * Relasi dengan model DetailPesanan
     * Satu produk bisa ada di banyak detail pesanan.
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }
}
