<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('event_type')->nullable();
            $table->string('order_id')->nullable();
            $table->json('payload');
            $table->json('headers')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('processed')->default(false);
            $table->text('processing_result')->nullable();
            $table->timestamps();

            $table->index('source');
            $table->index('order_id');
            $table->index('created_at');
            $table->index('processed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
    }
};
