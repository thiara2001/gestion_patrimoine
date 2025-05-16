<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    /** @use HasFactory<\Database\Factories\AlerteFactory> */
    use HasFactory;
     protected $fillable = [
        'id_utilisaeur',
        'nom',
        'description',
        'typeAlerte',
        'destinataire'
        
    ];
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
}
