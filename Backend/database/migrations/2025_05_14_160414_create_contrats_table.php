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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_utilisateur'); // Ajout de la colonne
            $table->foreign('id_utilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->unsignedBigInteger('id_paiement'); // Ajout de la colonne
            $table->foreign('id_paiement')->references('id')->on('paiements')->onDelete('cascade');
            $table->string('localisation');
            $table->string('nomlocal');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->double('montant_loyer');
            $table->double('montant_caution');
        

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');
    }
};
