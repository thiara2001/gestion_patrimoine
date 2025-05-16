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
        Schema::create('reservation_pavillon', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('id_utilisateur'); // Ajout de la colonne
            $table->foreign('id_utilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->unsignedBigInteger('id_site'); // Ajout de la colonne
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
            $table->String('niveauEtude');
            $table->String('nomPavillon');
            $table->String('nomChambre');
            $table->integer('nombreCredit');
            $table->double('moyenneAnnuel');
            $table->String('document');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_pavillon');
    }
};
