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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->String('nom');
            $table->String('prenom');
            $table->String('email')->unique();
             $table->string('password');
            $table->String('sexe');
            $table->integer('age');
            $table->String('adresse');
            $table->String('telephone');
            $table->String('type');
            $table->enum('role', ['Gestionnaire','Technicien','AgentQHSE','Commercant','Etudiant']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
