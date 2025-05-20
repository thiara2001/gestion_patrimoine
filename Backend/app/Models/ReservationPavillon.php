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
        'id_site',
        'niveauEtude',
        'nomPavillon',
        'nomChambre',
        'nombreCredit',
        'moyenneAnnuel',
        'document'
    ];
    public function affectation()
    {
        return $this->hasMany(Affectation::class);
    }
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
     public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }

}
