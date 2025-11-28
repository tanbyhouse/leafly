<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'event_type',
        'order_id',
        'payload',
        'headers',
        'ip_address',
        'processed',
        'processing_result',
    ];

    protected $casts = [
        'payload' => 'array',
        'headers' => 'array',
        'processed' => 'boolean',
    ];
}
