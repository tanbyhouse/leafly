<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            CategorySeeder::class,
            CareGuideSeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            AddressSeeder::class,
            CartSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            PaymentSeeder::class,
            ProductReviewSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
