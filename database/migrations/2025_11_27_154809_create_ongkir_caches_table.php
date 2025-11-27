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
        Schema::create('ongkir_caches', function (Blueprint $table) {
            $table->id();
            $table->string('origin');
            $table->string('destination');
            $table->string('kurir');
            $table->integer('berat');
            $table->decimal('biaya', 12, 2);
            $table->string('layanan');
            $table->integer('estimasi_hari');
            $table->text('deskripsi')->nullable();
            $table->timestamp('expired_at');
            $table->timestamps();

            $table->index(['origin', 'destination', 'kurir', 'berat']);
            $table->index('expired_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ongkir_caches');
    }
};
