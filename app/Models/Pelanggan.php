<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama',
        'telepon',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alamatPelanggans()
    {
        return $this->hasMany(AlamatPelanggan::class);
    }

    public function alamatUtama()
    {
        return $this->hasOne(AlamatPelanggan::class)->where('alamat_utama', true);
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function penilaianProduks()
    {
        return $this->hasMany(PenilaianProduk::class);
    }

    public function percakapans()
    {
        return $this->hasMany(Percakapan::class);
    }
}
