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
        Schema::create('contact_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutritionist_id')->constrained('users');
            $table->foreignId('commune_id')->constrained('communes');
            $table->string('description')->nullable();
            $table->string('address');
            $table->string('slogan')->nullable();
            $table->string('specialties')->nullable();
            $table->string('experiences')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_cards');
    }
};
