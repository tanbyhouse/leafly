<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        OrderItem::insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'price' => 15000,
                'quantity' => 2,
                'subtotal' => 30000,
            ],
            [
                'order_id' => 2,
                'product_id' => 2,
                'price' => 25000,
                'quantity' => 2,
                'subtotal' => 50000,
            ],
        ]);
    }
}
