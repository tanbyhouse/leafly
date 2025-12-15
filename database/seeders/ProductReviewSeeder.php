<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductReview;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        ProductReview::create([
            'product_id' => 1, // Benih Cabai Rawit
            'user_id' => 3,    // Siti Aminah
            'order_id' => 1,   // ORD-0001
            'rating' => 5,
            'review' => 'Benih tumbuh dengan sangat baik dan cepat berbuah.',
            'is_verified_purchase' => true,
        ]);
    }
}
