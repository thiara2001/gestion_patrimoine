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
<<<<<<< HEAD
=======
        'id_technicien',
        'id_agent',
        'nom',
>>>>>>> c530ec14f7a88e7e7107b305514ce64b621c72fc
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
