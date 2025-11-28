<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kota extends Model
{
    use HasFactory;

    protected $fillable = [
        'provinsi_id',
        'kode_kota',
        'nama_kota',
        'tipe',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }

    public function alamatPelanggans()
    {
        return $this->hasMany(AlamatPelanggan::class);
    }
}
