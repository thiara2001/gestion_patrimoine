<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    /** @use HasFactory<\Database\Factories\ReclamationFactory> */
    use HasFactory;
      protected $fillable = [
        'id_utilisateur',
        'description',
        'localisation',
        
    ];
   
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }
    
}
