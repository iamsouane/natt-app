<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tirages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_tontine');
            $table->integer('numero_seance'); // Ajout du numéro de séance
            $table->timestamp('date_tirage')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        
            // Clés étrangères
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_tontine')->references('id')->on('tontines')->onDelete('cascade');
        
            // Contrainte unique : Un utilisateur ne peut gagner qu'une seule fois par séance dans une tontine
            $table->unique(['id_user', 'id_tontine', 'numero_seance']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tirages');
    }
};
