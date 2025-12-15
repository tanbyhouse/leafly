<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\City;
use App\Models\Province;

class CitySeeder extends Seeder
{
    public function run()
    {
        $jatim = Province::where('name', 'Jawa Timur')->first();
        $jateng = Province::where('name', 'Jawa Tengah')->first();
        $jabar = Province::where('name', 'Jawa Barat')->first();

        City::insert([
            ['province_id' => $jatim->id, 'name' => 'Jember'],
            ['province_id' => $jatim->id, 'name' => 'Surabaya'],
            ['province_id' => $jatim->id, 'name' => 'Malang'],
            ['province_id' => $jateng->id, 'name' => 'Semarang'],
            ['province_id' => $jabar->id, 'name' => 'Bandung'],
        ]);
    }
}
