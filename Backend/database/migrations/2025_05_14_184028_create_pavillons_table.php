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
        Schema::create('pavillons', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('id_site'); // Ajout de la colonne
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
            $table->String('nomPavillon');
            $table->integer('nombreChambre');
            $table->integer('nombreSalle');
            $table->integer('nombreToilette');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pavillons');
    }
};
