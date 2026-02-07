<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $fillable = ['user_id', 'produk_id', 'jumlah'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
