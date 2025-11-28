<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('path_foto');
            $table->boolean('foto_utama')->default(false);
            $table->timestamps();

            $table->index('produk_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_produks');
    }
};
