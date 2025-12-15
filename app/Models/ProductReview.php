<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'review',
        'is_verified_purchase',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
