<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_id',
        'cara_perawatan_id',
        'kode_produk',
        'nama_produk',
        'deskripsi',
        'jenis_produk',
        'harga',
        'stok',
        'berat',
        'tanggal_kadaluarsa',
        'is_aktif',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'berat' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
        'is_aktif' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function caraPerawatan()
    {
        return $this->belongsTo(CaraPerawatan::class);
    }

    public function fotoProduks()
    {
        return $this->hasMany(FotoProduk::class);
    }

    public function penilaianProduks()
    {
        return $this->hasMany(PenilaianProduk::class);
    }

    public function produkRusaks()
    {
        return $this->hasMany(ProdukRusak::class);
    }

    public function getFotoUtamaAttribute()
    {
        return $this->fotoProduks()->where('foto_utama', true)->first();
    }

    public function getRataRatingAttribute()
    {
        return $this->penilaianProduks()->avg('rating');
    }
}
