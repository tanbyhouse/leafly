<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OngkirCache extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin',
        'destination',
        'kurir',
        'berat',
        'biaya',
        'layanan',
        'estimasi_hari',
        'deskripsi',
        'expired_at',
    ];

    protected $casts = [
        'biaya' => 'decimal:2',
        'expired_at' => 'datetime',
    ];

    public function scopeValid($query)
    {
        return $query->where('expired_at', '>', now());
    }
}
