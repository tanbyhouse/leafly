<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductReview;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        ProductReview::insert([
            [
                'product_id' => 1,
                'user_id' => 3,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Benih tumbuh dengan sangat baik dan cepat berbuah.',
                'is_verified_purchase' => true,
            ],
            [
                'product_id' => 2,
                'user_id' => 3,
                'order_id' => 2,
                'rating' => 5,
                'review' => 'Pupuknya sangat bagus, sangat membantu dalam pertumbuhan tanaman',
                'is_verified_purchase' => true,
            ],
        ]);
    }
}
