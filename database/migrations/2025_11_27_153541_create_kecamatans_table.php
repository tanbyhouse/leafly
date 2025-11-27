<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kota_id')->constrained('kotas')->onDelete('cascade');
            $table->string('kode_kecamatan', 10)->unique();
            $table->string('nama_kecamatan');
            $table->timestamps();

            $table->index('kota_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};
