<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_pesanan',
        'pelanggan_id',
        'alamat_id',
        'subtotal',
        'ongkos_kirim',
        'pajak',
        'diskon',
        'total',
        'metode_pembayaran',
        'status_pembayaran',
        'status_pesanan',
        'catatan_pelanggan',
        'catatan_admin',
        'tanggal_dibatalkan',
        'alasan_pembatalan',
        'dibatalkan_oleh',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'ongkos_kirim' => 'decimal:2',
        'pajak' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2',
        'tanggal_dibatalkan' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatPelanggan::class, 'alamat_id');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }

    public function pembatalanPesanan()
    {
        return $this->hasOne(PembatalanPesanan::class);
    }
}
