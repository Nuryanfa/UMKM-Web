<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis'; // Pastikan nama tabel benar, biasanya Laravel akan otomatis mengenali 'transaksis'
    protected $primaryKey = 'id';    // Pastikan primary key benar
    public $timestamps = true;       // Sesuaikan jika Anda tidak menggunakan timestamps

    protected $fillable = [
    'user_id',
    'supplier_id',
    'pesanan_id',
    'pembayaran_id',
    'pengiriman_id',
    'kurir_id',
    'kode_transaksi',
    'total_transaksi',
    'status_transaksi',
    'nama_kurir',
    'nomor_telepon_kurir',
    'order_id',
    'total_price',
    'payment_status',
    'delivery_address',
    'courier_name',
    'shipping_cost',
    'snap_token',
    'transaction_id',
    'payment_method',
    'status_code',
    'raw_response',
];


    /**
     * Relasi dengan model User (Pelanggan)
     */
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi dengan model User (Supplier)
     * Ini penting agar transaksi bisa terkait dengan supplier yang produknya dibeli.
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    /**
     * Relasi dengan model DetailPesanan
     * Satu transaksi bisa memiliki banyak detail pesanan.
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'transaksi_id');
    }
    public function products()
{
    return $this->belongsToMany(Produk::class, 'produk_transaksi')
                ->withPivot('quantity', 'price_at_order')
                ->withTimestamps();
}
}
