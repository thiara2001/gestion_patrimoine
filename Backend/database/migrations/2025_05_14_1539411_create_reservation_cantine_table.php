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
        Schema::create('reservation_cantine', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('id_utilisateur'); // Ajout de la colonne
           $table->foreign('id_utilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
           $table->unsignedBigInteger('id_site'); // Ajout de la colonne
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
            $table->String('description');
            $table->String('choixSite');
            $table->String('motifDemande');
            $table->String('produitouservice');
            $table->String('document');
            $table->String('qualiteQHSE');
            $table->enum('statutPaiement', ['en_attente', 'refuse', 'payer']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_cantine');
    }
};
