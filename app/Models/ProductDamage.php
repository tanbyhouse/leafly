<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDamage extends Model
{
    protected $fillable = ['product_id', 'quantity', 'reason', 'reported_by'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
