<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;

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
}
