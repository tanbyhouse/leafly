<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();

            $table->string('source');              // midtrans, rajaongkir, dll
            $table->string('event_type')->nullable();

            $table->string('order_id')->nullable(); // simpan order_number / gateway order_id (string)
            $table->json('payload');
            $table->json('headers')->nullable();

            $table->string('ip_address', 45)->nullable();

            $table->boolean('processed')->default(false);
            $table->text('processing_result')->nullable();

            $table->timestamps();

            $table->index('source');
            $table->index('order_id');
            $table->index(['processed', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
    }
};
