<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    /** @use HasFactory<\Database\Factories\PaiementFactory> */
    use HasFactory;
     protected $fillable = [
        'id_utilisateur',
        'localisation',
        'nomBatiment',
        'typeBatiment',
        'TypeLocal',
        'nomLocal',
        'typePaiement',
        'somme',
        'modePaiement',
        'date_Paiement',
        'reference'
    ];
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
    public function contrat()
    {
        return $this->hasMany(Contrat::class);
    }
}
