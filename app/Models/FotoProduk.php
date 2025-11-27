<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'path_foto',
        'foto_utama',
    ];

    protected $casts = [
        'foto_utama' => 'boolean',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function getFotoUrlAttribute()
    {
        return asset('storage/' . $this->path_foto);
    }
}
