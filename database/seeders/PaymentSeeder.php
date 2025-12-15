<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::create([
            'order_id' => 1,
            'gateway' => 'midtrans',
            'transaction_id' => 'TRX-001',
            'amount' => 40000,
            'status' => 'success',
        ]);
    }
}
