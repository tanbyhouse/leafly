<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_paket_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_paket_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('produk_item_id')->constrained('produks')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            $table->index('produk_paket_id');
            $table->index('produk_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_paket_produks');
    }
};
