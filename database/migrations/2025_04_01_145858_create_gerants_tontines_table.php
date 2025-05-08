<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gerants_tontines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tontine');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_tontine')->references('id')->on('tontines')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['id_tontine', 'id_user']); // Évite les doublons
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gerants_tontines');
    }
};