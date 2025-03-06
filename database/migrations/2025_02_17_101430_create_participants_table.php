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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->unique(); // Un utilisateur ne peut avoir qu'un seul profil participant
            $table->date('date_naissance');
            $table->string('cni')->unique();
            $table->string('adresse');
            $table->string('image_cni')->nullable();
            $table->timestamps();
        
            // Clé étrangère
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
