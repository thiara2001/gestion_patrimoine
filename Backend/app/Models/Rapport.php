<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    /** @use HasFactory<\Database\Factories\RapportFactory> */
    use HasFactory;
      protected $fillable = [
        'id_utilisateur',
        'typeRapport',
        'contenue',
        'dateGeneration',
    ];
    
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }
    
}
