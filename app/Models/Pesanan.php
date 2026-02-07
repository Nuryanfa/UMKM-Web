<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'pesanan_id',
    'order_id',
    'total_price',
    'payment_status',
    'delivery_address',
    'courier_name',
    'shipping_cost',
    'snap_token',
    ];

    // Jika ingin relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Jika ingin relasi ke transaksi
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
