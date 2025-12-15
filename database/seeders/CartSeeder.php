<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        Cart::insert([
            [
                'user_id' => 3,
                'product_id' => 1,
                'quantity' => 2,
            ],
            [
                'user_id' => 3,
                'product_id' => 2,
                'quantity' => 3,
            ],
        ]);
    }
}
