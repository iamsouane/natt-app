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
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id(); // Ajout d'un ID auto-incrémenté
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_tontine');
            $table->integer('montant');
            $table->enum('moyen_paiement', ['ESPECES', 'WAVE', 'OM']);
            $table->timestamps();
        
            // Clés étrangères
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_tontine')->references('id')->on('tontines')->onDelete('cascade');
        
            // Clé unique composée
            $table->unique(['id_user', 'id_tontine']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
