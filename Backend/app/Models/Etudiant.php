<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    /** @use HasFactory<\Database\Factories\EtudiantFactory> */
    use HasFactory;
    
    protected $fillable = [
        'id_utilisateur',
        'id_filiere',
        'numDossier',
        'niveauEtude',
    ];

    public function getUserType(){
        return 'Etudiant';
    }

    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
     public function filiere(){
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
}
