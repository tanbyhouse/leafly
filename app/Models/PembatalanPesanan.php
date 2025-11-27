<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembatalanPesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'diminta_oleh',
        'alasan',
        'status',
        'direview_oleh',
        'catatan_review',
        'tanggal_review',
    ];

    protected $casts = [
        'tanggal_review' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function peminta()
    {
        return $this->belongsTo(User::class, 'diminta_oleh');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'direview_oleh');
    }
}
