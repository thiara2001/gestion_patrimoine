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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_utilisateur'); // Ajout de la colonne
            $table->foreign('id_utilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->String('localisation');
            $table->String('nomBatiment');
            $table->String('typeBatiment');
            $table->enum('TypeLocal',['Cantine', 'Chambre']);
            $table->String('nomLocal');
            $table->enum('typePaiement', ['Caution', 'Mensualité']);
            $table->double('somme');
            $table->String('modePaiement');
            $table->date('date_Paiement');
            $table->String('reference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
