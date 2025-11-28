<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

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

    public function fotoUtama()
    {
        return $this->hasOne(FotoProduk::class)->where('foto_utama', true);
    }

    public function produkRusaks()
    {
        return $this->hasMany(ProdukRusak::class);
    }

    public function penilaianProduks()
    {
        return $this->hasMany(PenilaianProduk::class);
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function itemDalamPaket()
    {
        return $this->hasMany(DetailPaketProduk::class, 'produk_paket_id');
    }

    public function paketYangMemiliki()
    {
        return $this->hasMany(DetailPaketProduk::class, 'produk_item_id');
    }

    public function getRataRatingAttribute()
    {
        return $this->penilaianProduks()->avg('rating');
    }

    public function getTotalUlasanAttribute()
    {
        return $this->penilaianProduks()->count();
    }

    public function getStokTersediaAttribute()
    {
        return $this->stok > 0;
    }
}
