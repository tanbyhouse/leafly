<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'tipe_user',
        'aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'aktif' => 'boolean',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class);
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function produkRusaks()
    {
        return $this->hasMany(ProdukRusak::class, 'dilaporkan_oleh');
    }

    public function pesansDikirim()
    {
        return $this->hasMany(Pesan::class, 'pengirim_id');
    }

    public function isAdmin()
    {
        return $this->tipe_user === 'admin';
    }

    public function isKaryawan()
    {
        return $this->tipe_user === 'karyawan';
    }

    public function isPelanggan()
    {
        return $this->tipe_user === 'pelanggan';
    }
}
