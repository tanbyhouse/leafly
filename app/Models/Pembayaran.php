<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'nama_payment_gateway',
        'id_transaksi_gateway',
        'snap_token',
        'jumlah',
        'status',
        'url_pembayaran',
        'metode_pembayaran',
        'bank_va_number',
        'bank_name',
        'tanggal_dibayar',
        'tanggal_kadaluarsa',
        'data_response',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_dibayar' => 'datetime',
        'tanggal_kadaluarsa' => 'datetime',
        'data_response' => 'array',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
