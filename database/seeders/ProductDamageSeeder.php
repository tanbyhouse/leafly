<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductDamage;

class ProductDamageSeeder extends Seeder
{
    public function run(): void
    {
        ProductDamage::create([
            'product_id' => 1,
            'quantity' => 5,
            'reason' => 'Kemasan rusak saat pengiriman',
            'reported_by' => 2,
        ]);

        ProductDamage::create([
            'product_id' => 2,
            'quantity' => 2,
            'reason' => 'Produk terkena air hujan',
            'reported_by' => 2,
        ]);
    }
}
