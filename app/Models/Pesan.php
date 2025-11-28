<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'percakapan_id',
        'pengirim_id',
        'isi_pesan',
        'sudah_dibaca',
        'dibaca_pada',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'dibaca_pada' => 'datetime',
    ];

    public function percakapan()
    {
        return $this->belongsTo(Percakapan::class);
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
}
