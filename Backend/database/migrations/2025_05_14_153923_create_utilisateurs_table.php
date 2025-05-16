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
<<<<<<< HEAD
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
=======
            $table->String('email')->unique();
             $table->string('password');
>>>>>>> ba563af2d2ab6b6f3fe28caf7248a02937ff67bb
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
