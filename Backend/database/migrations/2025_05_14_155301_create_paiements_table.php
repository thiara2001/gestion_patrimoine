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
            $table->unsignedBigInteger('id_cantine'); // Ajout de la colonne
            $table->foreign(columns: 'id_cantine')->references('id')->on('reservation_cantine')->onDelete('cascade');
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
            $table->enum('statut', ['en_attente', 'refuse', 'valider']);
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
