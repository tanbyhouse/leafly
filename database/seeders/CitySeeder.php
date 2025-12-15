<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run()
    {
        City::insert([
            ['province_id' => 1, 'name' => 'Jember'],
            ['province_id' => 1, 'name' => 'Surabaya'],
            ['province_id' => 1, 'name' => 'Malang'],
            ['province_id' => 2, 'name' => 'Semarang'],
            ['province_id' => 3, 'name' => 'Bandung'],
        ]);
    }
}
