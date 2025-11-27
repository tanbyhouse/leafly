<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPaketProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_paket_id',
        'produk_item_id',
        'jumlah',
    ];

    public function produkPaket()
    {
        return $this->belongsTo(Produk::class, 'produk_paket_id');
    }

    public function produkItem()
    {
        return $this->belongsTo(Produk::class, 'produk_item_id');
    }
}
