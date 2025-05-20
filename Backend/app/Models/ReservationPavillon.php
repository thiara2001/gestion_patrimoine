<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationPavillon extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationPavillonFactory> */
    use HasFactory;

     protected $table = 'reservation_pavillons';
     
     protected $fillable = [
        'id_utilisateur',
        'id_pavillon',
        'niveauEtude',
        'nomPavillon',
        'nomChambre',
        'nombreCredit',
        'moyenneAnnuel',
        'document',
        'statut',
        'statutPaiement'
    ];
    public function affectation()
    {
        return $this->hasMany(Affectation::class);
    }
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
     public function pavillon()
    {
        return $this->belongsTo(Pavillon::class, 'id_pavillon');
    }

}
