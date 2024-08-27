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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('patient_id')->constrained('users');
            $table->unsignedBigInteger('height');
            $table->unsignedBigInteger('weight');
            $table->unsignedBigInteger('bicipital_skinfold')->nullable();
            $table->unsignedBigInteger('tricipital_skinfold')->nullable();
            $table->unsignedBigInteger('subescapular_skinfold')->nullable();
            $table->unsignedBigInteger('supraspinal_skinfold')->nullable();
            $table->unsignedBigInteger('suprailiac_skinfold')->nullable();
            $table->unsignedBigInteger('pb_relaj')->nullable();
            $table->unsignedBigInteger('pb_contra')->nullable();
            $table->unsignedBigInteger('forearm')->nullable();
            $table->unsignedBigInteger('thigh')->nullable();
            $table->unsignedBigInteger('calf')->nullable();
            $table->unsignedBigInteger('waist')->nullable();
            $table->unsignedBigInteger('thorax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
