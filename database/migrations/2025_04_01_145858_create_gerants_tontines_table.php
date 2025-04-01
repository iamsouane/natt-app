<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gerants_tontines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gerant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tontine_id')->constrained('tontines')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gerants_tontines');
    }
};