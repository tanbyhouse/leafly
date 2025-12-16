<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        ProductImage::insert([
            ['product_id' => 1, 'path' => 'products/cabai.jpg', 'is_primary' => true],
            ['product_id' => 2, 'path' => 'products/pupuk.jpg', 'is_primary' => true],
            ['product_id' => 3, 'path' => 'products/pompa.jpg', 'is_primary' => true],
        ]);
    }
}
