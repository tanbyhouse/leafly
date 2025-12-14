<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::first();

        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'BNH-001',
            'name' => 'Benih Tomat Cherry',
            'description' => 'Benih tomat unggul',
            'type' => 'benih',
            'price' => 15000,
            'stock' => 100,
            'weight' => 50,
            'is_active' => true,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'path' => 'products/tomat.jpg',
            'is_primary' => true,
        ]);
    }
}
