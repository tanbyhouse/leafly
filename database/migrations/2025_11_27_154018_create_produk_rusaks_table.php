<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_rusaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('jumlah');
            $table->text('alasan');
            $table->foreignId('dilaporkan_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamp('tanggal_laporan')->useCurrent();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index('produk_id');
            $table->index('tanggal_laporan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_rusaks');
    }
};
