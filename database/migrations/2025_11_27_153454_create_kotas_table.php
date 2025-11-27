<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provinsi_id')->constrained('provinsis')->onDelete('cascade');
            $table->string('kode_kota', 10)->unique();
            $table->string('nama_kota');
            $table->string('tipe')->nullable();
            $table->timestamps();

            $table->index('provinsi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kotas');
    }
};
