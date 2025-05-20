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
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_utilisateur'); // Ajout de la colonne
            $table->foreign('id_utilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->unsignedBigInteger('id_agent'); // Ajout de la colonne
            $table->foreign('id_agent')->references('id')->on('agent_q_h_s_e_s')->onDelete('cascade');
            $table->unsignedBigInteger('id_technicien'); // Ajout de la colonne
            $table->foreign('id_technicien')->references('id')->on('techniciens')->onDelete('cascade');
            $table->String('description');
            $table->String('typeAlerte');
            $table->boolean('lu')->default(false);
            $table->String('destinataire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertes');
    }
};
