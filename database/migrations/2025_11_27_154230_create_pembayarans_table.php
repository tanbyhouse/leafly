<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->string('nama_payment_gateway', 50)->nullable();
            $table->string('id_transaksi_gateway')->unique()->nullable();
            $table->string('snap_token')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['pending', 'berhasil', 'gagal', 'kadaluarsa', 'refund'])->default('pending');
            $table->text('url_pembayaran')->nullable();
            $table->string('metode_pembayaran', 50)->nullable();
            $table->string('bank_va_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->timestamp('tanggal_dibayar')->nullable();
            $table->timestamp('tanggal_kadaluarsa')->nullable();
            $table->json('data_response')->nullable();
            $table->timestamps();

            $table->index('pesanan_id');
            $table->index('id_transaksi_gateway');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
