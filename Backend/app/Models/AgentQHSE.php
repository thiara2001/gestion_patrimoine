<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentQHSE extends Utilisateur
{
    /** @use HasFactory<\Database\Factories\AgentQHSEFactory> */
    use HasFactory;
    protected $fillable = [
        
    ];

    public function getUserType(){
        return 'AgentQHSE';
    }


    public function controleQHSE(){
        return $this->hasMany(ControleQHSE::class, 'id_utilisateur');
    }

    // Relation avec les alertes
    public function alertes()
    {
        return $this->hasMany(Alerte::class);
    }
}
