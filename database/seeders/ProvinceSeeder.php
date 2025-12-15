<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    public function run(): void
    {
        Province::insert([
            ['id' => 1, 'name' => 'Jawa Timur'],
            ['id' => 2, 'name' => 'Jawa Tengah'],
            ['id' => 3, 'name' => 'Jawa Barat'],
        ]);
    }
}
