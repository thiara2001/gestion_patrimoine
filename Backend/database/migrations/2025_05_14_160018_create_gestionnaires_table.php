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
        Schema::create('gestionnaires', function (Blueprint $table) {
            $table->unsignedBigInteger('id'); // Ajout de la colonne
            $table->foreign('id')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->primary('id');
            $table->enum('roleGestionnaire', ['Chef de pavillon', 'Administrateur', 'Agent Comptable', 'chef du service']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestionnaires');
    }
};
