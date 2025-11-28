<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukRusak extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'jumlah',
        'alasan',
        'dilaporkan_oleh',
        'tanggal_laporan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_laporan' => 'datetime',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'dilaporkan_oleh');
    }
}
