<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->foreignId('cara_perawatan_id')->nullable()->constrained('cara_perawatans')->onDelete('set null');
            $table->string('kode_produk', 100)->unique();
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_produk', ['benih', 'bibit', 'alat', 'paket']);
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0);
            $table->decimal('berat', 8, 2)->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('kategori_id');
            $table->index('cara_perawatan_id');
            $table->index('jenis_produk');
            $table->index('kode_produk');
            $table->index('is_aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
