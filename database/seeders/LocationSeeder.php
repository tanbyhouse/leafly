<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\City;
use App\Models\District;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $province = Province::create([
            'name' => 'Jawa Timur',
        ]);

        $city = City::create([
            'province_id' => $province->id,
            'name' => 'Surabaya',
            'rajaongkir_id' => '3578',
        ]);

        District::insert([
            [
                'city_id' => $city->id,
                'name' => 'Gubeng',
                'rajaongkir_id' => '357801',
            ],
            [
                'city_id' => $city->id,
                'name' => 'Tegalsari',
                'rajaongkir_id' => '357802',
            ],
        ]);
    }
}
