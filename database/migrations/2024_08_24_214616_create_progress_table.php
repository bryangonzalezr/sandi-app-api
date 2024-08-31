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
            $table->float('imc');
            $table->float('density');
            $table->float('fat_percentage');
            $table->float('z_muscular');
            $table->float('muscular_mass'); //Masa Muscular
            $table->float('muscular_percentage'); // Porcentaje Muscular
            $table->float('pmb'); // Perimetro Muscular Braquial
            $table->float('amb'); // Area Muscular Braquial
            $table->float('agb'); // Area Grasa Braquial
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
