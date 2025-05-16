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
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_reservationCantine'); // Ajout de la colonne
            $table->foreign('id_reservationCantine')->references('id')->on('reservation_cantine')->onDelete('cascade');
            $table->unsignedBigInteger('id_reservationPavillon'); // Ajout de la colonne
            $table->foreign('id_reservationPavillon')->references('id')->on('reservation_pavillon')->onDelete('cascade');
            $table->date('date_affectation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
