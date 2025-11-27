<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('restrict');
            $table->string('nama_produk');
            $table->string('kode_produk', 100);
            $table->decimal('harga', 12, 2);
            $table->integer('jumlah');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->index('pesanan_id');
            $table->index('produk_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
