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
        Schema::create('tontines', function (Blueprint $table) {
            $table->id();
            $table->enum('frequence',
                [
                    'JOURNALIERE',
                    'HEBDOMADAIRE',
                    'MENSUELLE'
                ]);
            $table->string('libelle');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('description');
            $table->integer('montant_total');
            $table->integer('montant_de_base');
            $table->integer('nbre_participant');
            $table->integer('nbre_cotisation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tontines');
    }
};
