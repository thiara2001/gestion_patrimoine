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
        Schema::create('chambres', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('id_pavillon'); // Ajout de la colonne
            $table->foreign('id_pavillon')->references('id')->on('pavillons')->onDelete('cascade');
            $table->String('numChambre');
            $table->integer('nombreLits');
            $table->boolean('toiletteInterieur');
            $table->integer('nbreLampe');
            $table->integer('nombrePrise');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambres');
    }
};
