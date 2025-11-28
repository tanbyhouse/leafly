<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaraPerawatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_perawatan',
        'deskripsi',
        'langkah_penyiraman',
        'langkah_pemupukan',
        'langkah_pencahayaan',
        'tips_tambahan',
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
