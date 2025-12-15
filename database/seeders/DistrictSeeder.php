<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        District::insert([
            ['city_id' => 1, 'name' => 'Kaliwates'],
            ['city_id' => 1, 'name' => 'Sumbersari'],
            ['city_id' => 2, 'name' => 'Wonokromo'],
            ['city_id' => 3, 'name' => 'Lowokwaru'],
            ['city_id' => 4, 'name' => 'Tembalang'],
            ['city_id' => 5, 'name' => 'Cicendo'],
        ]);
    }
}
