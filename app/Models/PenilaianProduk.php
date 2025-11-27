<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianProduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'produk_id',
        'pelanggan_id',
        'pesanan_id',
        'rating',
        'ulasan',
        'is_verified_purchase',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
