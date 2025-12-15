<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::create([
            'order_number' => 'ORD-0001',
            'user_id' => 3,
            'address_id' => 1,
            'subtotal' => 30000,
            'shipping_cost' => 10000,
            'total' => 40000,
            'payment_method' => 'transfer',
            'payment_status' => 'paid',
            'order_status' => 'processed',
        ]);
    }
}
