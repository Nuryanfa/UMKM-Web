<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanans'; // Pastikan nama tabel benar
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'transaksi_id', // Foreign key ke tabel transaksis
        'produk_id',    // Foreign key ke tabel produks
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    /**
     * Relasi dengan model Transaksi
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    /**
     * Relasi dengan model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
