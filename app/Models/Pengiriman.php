<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimen';

    protected $fillable = [
        'pesanan_id',
        'kode_kurir',
        'nama_kurir',
        'tipe_layanan',
        'deskripsi_layanan',
        'nomor_resi',
        'estimasi_tiba',
        'estimasi_hari',
        'biaya_ongkir',
        'tanggal_dikirim',
        'tanggal_diterima',
        'status',
        'lokasi_terakhir',
        'catatan',
        'data_tracking',
    ];

    protected $casts = [
        'estimasi_tiba' => 'date',
        'biaya_ongkir' => 'decimal:2',
        'tanggal_dikirim' => 'datetime',
        'tanggal_diterima' => 'datetime',
        'data_tracking' => 'array',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
