<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        Address::create([
            'user_id' => 3,
            'label' => 'Rumah',
            'recipient_name' => 'Siti Aminah',
            'recipient_phone' => '081234567890',
            'address_detail' => 'Jl. Mawar No. 10',
            'province_id' => 1,
            'city_id' => 1,
            'district_id' => 1,
            'postal_code' => '68121',
            'is_primary' => true,
        ]);
    }
}
