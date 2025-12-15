<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_cost_caches', function (Blueprint $table) {
            $table->id();

            $table->string('origin_type', 20);
            $table->string('origin_id', 50);

            $table->string('destination_type', 20);
            $table->string('destination_id', 50);

            $table->string('courier', 50);
            $table->integer('weight');

            $table->string('service', 50);
            $table->string('service_description')->nullable();
            $table->integer('cost');
            $table->integer('etd');

            $table->timestamp('expired_at');

            $table->timestamps();

            // 🔑 INDEX PENDEK & AMAN
            $table->index(
                [
                    'origin_type',
                    'origin_id',
                    'destination_type',
                    'destination_id',
                    'courier',
                    'weight'
                ],
                'idx_shipping_cost_lookup'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_cost_caches');
    }
};
