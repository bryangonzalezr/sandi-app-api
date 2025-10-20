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
        Schema::create('portions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cereales');
            $table->bigInteger('verduras_gral');
            $table->bigInteger('verduras_libre_cons');
            $table->bigInteger('frutas');
            $table->bigInteger('carnes_ag');
            $table->bigInteger('carnes_bg');
            $table->bigInteger('legumbres');
            $table->bigInteger('lacteos_ag');
            $table->bigInteger('lacteos_bg');
            $table->bigInteger('lacteos_mg');
            $table->bigInteger('aceites_grasas');
            $table->bigInteger('alim_ricos_lipidos');
            $table->bigInteger('azucares');
            $table->unsignedBigInteger('total_calorias')->nullable();
            $table->foreignId('patient_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portions');
    }
};
