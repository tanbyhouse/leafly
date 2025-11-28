<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kota_id',
        'kode_kecamatan',
        'nama_kecamatan',
    ];

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function alamatPelanggans()
    {
        return $this->hasMany(AlamatPelanggan::class);
    }
}
