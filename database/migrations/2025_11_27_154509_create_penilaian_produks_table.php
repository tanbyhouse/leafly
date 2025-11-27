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
        Schema::create('penilaian_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned();
            $table->text('ulasan')->nullable();
            $table->boolean('is_verified_purchase')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['produk_id', 'pelanggan_id', 'pesanan_id']);
            $table->index('produk_id');
            $table->index('pelanggan_id');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_produks');
    }
};
