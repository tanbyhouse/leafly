<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Percakapan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'staff_id',
        'subjek',
        'status',
        'pesan_terakhir_pada',
    ];

    protected $casts = [
        'pesan_terakhir_pada' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function pesans()
    {
        return $this->hasMany(Pesan::class);
    }

    public function pesanTerakhir()
    {
        return $this->hasOne(Pesan::class)->latestOfMany();
    }
}
