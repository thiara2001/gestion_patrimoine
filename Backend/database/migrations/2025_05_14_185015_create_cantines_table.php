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
        Schema::create('cantines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_site'); // Ajout de la colonne
            $table->foreign('id_site')->references('id')->on('sites')->onDelete('cascade');
            $table->String('numeroCantine');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cantines');
    }
};
