<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alamat_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->string('label', 50);
            $table->string('nama_penerima');
            $table->string('telepon', 20);
            $table->text('alamat_lengkap');
            $table->foreignId('kecamatan_id')->constrained('kecamatans')->onDelete('restrict');
            $table->foreignId('kota_id')->constrained('kotas')->onDelete('restrict');
            $table->foreignId('provinsi_id')->constrained('provinsis')->onDelete('restrict');
            $table->string('kode_pos', 10);
            $table->text('catatan')->nullable();
            $table->boolean('alamat_utama')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('pelanggan_id');
            $table->index('kecamatan_id');
            $table->index('kota_id');
            $table->index('provinsi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat_pelanggans');
    }
};
