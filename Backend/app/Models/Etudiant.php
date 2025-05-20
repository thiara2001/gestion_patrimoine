<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    /** @use HasFactory<\Database\Factories\EtudiantFactory> */
    use HasFactory;
    
    protected $fillable = [
        'id_filiere',
        'numDossier',
        'niveauEtude',
    ];

    public function getUserType(){
        return 'Etudiant';
    }

     public function filiere(){
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

       public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_utilisateur');
    }
    
    public function reservations()
    {
        return $this->hasMany(ReservationPavillon::class, 'id_utilisateur');
    }
}
