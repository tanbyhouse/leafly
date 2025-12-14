<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Benih Sayuran', 'description' => 'Benih berkualitas'],
            ['name' => 'Bibit Buah', 'description' => 'Bibit unggul'],
            ['name' => 'Alat Berkebun', 'description' => 'Peralatan kebun'],
        ]);
    }
}
