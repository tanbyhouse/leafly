<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareGuide extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'watering', 'fertilizing', 'lighting', 'tips'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
