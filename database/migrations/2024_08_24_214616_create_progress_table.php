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
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users');
            $table->unsignedBigInteger('imc');
            $table->unsignedBigInteger('density');
            $table->unsignedBigInteger('siri_fat_percentage');
            $table->unsignedBigInteger('slaughter_fat_percentage');
            $table->unsignedBigInteger('sum_perimeters');
            $table->unsignedBigInteger('z_muscular');
            $table->unsignedBigInteger('m_muscular');
            $table->unsignedBigInteger('pmb');
            $table->unsignedBigInteger('amb');
            $table->unsignedBigInteger('agb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
