<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cara_perawatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perawatan');
            $table->text('deskripsi')->nullable();
            $table->text('langkah_penyiraman')->nullable();
            $table->text('langkah_pemupukan')->nullable();
            $table->text('langkah_pencahayaan')->nullable();
            $table->text('tips_tambahan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cara_perawatans');
    }
};
