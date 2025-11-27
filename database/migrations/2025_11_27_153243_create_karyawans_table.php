<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_karyawan', 50)->unique();
            $table->string('nama');
            $table->string('telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->enum('status', ['aktif', 'cuti', 'non_aktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('user_id');
            $table->index('kode_karyawan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
