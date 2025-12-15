<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;
    protected $fillable = ['city_id', 'name', 'rajaongkir_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
