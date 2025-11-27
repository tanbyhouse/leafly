<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe',
        'judul',
        'pesan',
        'data',
        'sudah_dibaca',
        'dibaca_pada',
    ];

    protected $casts = [
        'data' => 'array',
        'sudah_dibaca' => 'boolean',
        'dibaca_pada' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
