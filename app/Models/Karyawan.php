<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'kode_karyawan',
        'nama',
        'telepon',
        'alamat',
        'tanggal_bergabung',
        'status',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
