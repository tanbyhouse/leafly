<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'care_guide_id',
        'sku',
        'name',
        'description',
        'type',
        'price',
        'stock',
        'weight',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function careGuide()
    {
        return $this->belongsTo(CareGuide::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function packageItems()
    {
        return $this->hasMany(ProductPackage::class, 'package_id');
    }
    public function partOfPackages()
    {
        return $this->hasMany(ProductPackage::class, 'item_id');
    }

    public function damages()
    {
        return $this->hasMany(ProductDamage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
