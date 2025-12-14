<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPackage extends Model
{
    protected $fillable = ['package_id', 'item_id', 'quantity'];

    public function package()
    {
        return $this->belongsTo(Product::class, 'package_id');
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }
}
