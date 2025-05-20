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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_technicien'); // Ajout de la colonne
            $table->foreign('id_technicien')->references('id')->on('techniciens')->onDelete('cascade');
            $table->unsignedBigInteger('id_equipement'); // Ajout de la colonne
            $table->foreign('id_equipement')->references('id')->on('equipements_tables')->onDelete('cascade');
            $table->unsignedBigInteger('id_site'); // Ajout de la colonne
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
            $table->String('descriptionProbleme');
            $table->String('actionEffectue');
            $table->enum('statut', ['en_cours', 'resolue']);
            $table->string('observations')->nullable();
            $table->date('dateIntervention');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
