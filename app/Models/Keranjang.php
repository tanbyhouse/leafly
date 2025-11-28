<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'produk_id',
        'jumlah',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->produk->harga * $this->jumlah;
    }
}
