<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    /** @use HasFactory<\Database\Factories\ContratFactory> */
    use HasFactory;
     protected $fillable = [
        'id_utilisateur',
        'id_paiement',
        'date_debut',
        'date_fin',
        'montant_loyer',
        'montant_caution'
    ];
   
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }
     public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'id_paiement');
    }
}
