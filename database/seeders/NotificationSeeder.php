<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        Notification::create([
            'user_id' => 3,
            'type' => 'order_status',
            'title' => 'Pesanan Diproses',
            'message' => 'Pesanan ORD-0001 sedang diproses',
            'data' => json_encode(['order_id' => 1]),
        ]);
    }
}
