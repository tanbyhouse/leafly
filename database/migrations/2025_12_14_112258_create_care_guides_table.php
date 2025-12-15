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
        Schema::create('care_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('watering')->nullable();
            $table->text('fertilizing')->nullable();
            $table->text('lighting')->nullable();
            $table->text('tips')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('care_guides');
    }
};
