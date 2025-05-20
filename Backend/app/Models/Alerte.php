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
        'id_technicien',
        'id_agent',
        'nom',
        'description',
        'typeAlerte',
        'lu',
        'destinataire'
        
    ];
    public function gestionnaire()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

     public function technicien()
    {
        return $this->belongsTo(Technicien::class, 'id_technicien');
    }
    
    public function agent()
    {
        return $this->belongsTo(AgentQHSE::class, 'id_agent');
    }


}
