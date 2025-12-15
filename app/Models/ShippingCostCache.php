<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCostCache extends Model
{
    protected $fillable = [
        'origin_type',
        'origin_id',
        'destination_type',
        'destination_id',
        'courier',
        'weight',
        'service',
        'service_description',
        'cost',
        'etd',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime'
    ];
}
