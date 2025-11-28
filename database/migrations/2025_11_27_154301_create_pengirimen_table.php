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
        Schema::create('pengirimen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->string('kode_kurir', 50);
            $table->string('nama_kurir', 100);
            $table->string('tipe_layanan', 50);
            $table->string('deskripsi_layanan')->nullable();
            $table->string('nomor_resi', 100)->unique()->nullable();
            $table->date('estimasi_tiba')->nullable();
            $table->integer('estimasi_hari')->nullable();
            $table->decimal('biaya_ongkir', 12, 2)->default(0);
            $table->timestamp('tanggal_dikirim')->nullable();
            $table->timestamp('tanggal_diterima')->nullable();
            $table->enum('status', ['pending', 'diambil', 'dalam_perjalanan', 'terkirim', 'dikembalikan', 'gagal'])->default('pending');
            $table->string('lokasi_terakhir')->nullable();
            $table->text('catatan')->nullable();
            $table->json('data_tracking')->nullable();
            $table->timestamps();

            $table->index('pesanan_id');
            $table->index('nomor_resi');
            $table->index('kode_kurir');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimen');
    }
};
