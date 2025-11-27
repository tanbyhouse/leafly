<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pesanan', 50)->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('alamat_id')->constrained('alamat_pelanggans')->onDelete('restrict');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('ongkos_kirim', 12, 2)->default(0);
            $table->decimal('pajak', 12, 2)->default(0);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->enum('metode_pembayaran', ['cod', 'transfer', 'payment_gateway']);
            $table->enum('status_pembayaran', ['pending', 'dibayar', 'gagal', 'refund'])->default('pending');
            $table->enum('status_pesanan', ['pending', 'dikonfirmasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan_pelanggan')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_dibatalkan')->nullable();
            $table->text('alasan_pembatalan')->nullable();
            $table->foreignId('dibatalkan_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('nomor_pesanan');
            $table->index('pelanggan_id');
            $table->index('status_pesanan');
            $table->index('status_pembayaran');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
