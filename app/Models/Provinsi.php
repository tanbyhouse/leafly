<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_provinsi',
        'nama_provinsi',
    ];

    public function kotas()
    {
        return $this->hasMany(Kota::class);
    }

    public function alamatPelanggans()
    {
        return $this->hasMany(AlamatPelanggan::class);
    }
}
