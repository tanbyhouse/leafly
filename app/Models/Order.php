<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'address_id',
        'subtotal',
        'shipping_cost',
        'total',
        'payment_method',
        'payment_status',
        'order_status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function cancellation()
    {
        return $this->hasOne(OrderCancellation::class);
    }
}
