<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlamatPelanggan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pelanggan_id',
        'label',
        'nama_penerima',
        'telepon',
        'alamat_lengkap',
        'kecamatan_id',
        'kota_id',
        'provinsi_id',
        'kode_pos',
        'catatan',
        'alamat_utama',
    ];

    protected $casts = [
        'alamat_utama' => 'boolean',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'alamat_id');
    }

    public function getAlamatLengkapFormatAttribute()
    {
        return $this->alamat_lengkap . ', ' .
            $this->kecamatan->nama_kecamatan . ', ' .
            $this->kota->nama_kota . ', ' .
            $this->provinsi->nama_provinsi . ' ' .
            $this->kode_pos;
    }
}
