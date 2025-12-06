<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Update Provinsi
        Schema::table('provinsis', function (Blueprint $table) {
            $table->string('rajaongkir_id')->nullable()->after('kode_provinsi');
        });

        // Update Kota
        Schema::table('kotas', function (Blueprint $table) {
            $table->string('rajaongkir_id')->nullable()->after('kode_kota');
        });
    }

    public function down()
    {
        Schema::table('provinsis', function (Blueprint $table) {
            $table->dropColumn('rajaongkir_id');
        });

        Schema::table('kotas', function (Blueprint $table) {
            $table->dropColumn('rajaongkir_id');
        });
    }
};
