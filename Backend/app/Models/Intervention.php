<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    /** @use HasFactory<\Database\Factories\InterventionFactory> */
    use HasFactory;

    protected $fillable = [
        'id_technicen',
        'id_equipement',
        'id_site',
        'descriptionProbleme',
        'actionEffectue',
        'statut',
        'observations',
        'dateIntervention'
    ];

    public function site(){
        return $this->belongsTo(Site::class, 'id_site');
    }
   
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }

     public function technicien()
    {
        return $this->belongsTo(Technicien::class, 'id_technicien');
    }
    
    public function equipement()
    {
        return $this->belongsTo(Equipement::class, 'id_equipement');
    }
    
}
