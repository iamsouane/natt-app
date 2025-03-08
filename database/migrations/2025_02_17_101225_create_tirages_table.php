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
        Schema::create('tirages', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_tontine');
            $table->timestamp('date_tirage')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        
            // Clés étrangères
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_tontine')->references('id')->on('tontines')->onDelete('cascade');
        
            // Contrainte unique pour garantir qu'un utilisateur ne gagne qu'une fois par tontine
            $table->unique(['id_user', 'id_tontine']);
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
