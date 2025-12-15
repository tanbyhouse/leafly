<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\CareGuide;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $pupuk = Category::where('name', 'Pupuk')->first();
        $benih = Category::where('name', 'Benih')->first();
        $alat = Category::where('name', 'Alat')->first();

        $careGuide = CareGuide::first();

        Product::insert([
            [
                'category_id' => $benih->id,
                'care_guide_id' => $careGuide->id,
                'sku' => 'PRD-001',
                'name' => 'Benih Cabai Rawit',
                'description' => 'Benih unggulan',
                'type' => 'benih',
                'price' => 15000,
                'stock' => 100,
                'weight' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $pupuk->id,
                'care_guide_id' => $careGuide->id,
                'sku' => 'PRD-002',
                'name' => 'Pupuk Organik',
                'description' => 'Pupuk ramah lingkungan',
                'type' => 'pupuk',
                'price' => 25000,
                'stock' => 50,
                'weight' => 500,
                'is_active' => true,
            ],
            [
                'category_id' => $alat->id,
                'care_guide_id' => $careGuide->id,
                'sku' => 'PRD-003',
                'name' => 'Pompa Air',
                'description' => 'Pompa Air untuk sistem aktif',
                'type' => 'alat',
                'price' => 50000,
                'stock' => 71,
                'weight' => 650,
                'is_active' => true,
            ],
        ]);
    }
}
