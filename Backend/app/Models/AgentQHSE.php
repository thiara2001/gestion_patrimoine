<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentQHSE extends Utilisateur
{
    /** @use HasFactory<\Database\Factories\AgentQHSEFactory> */
    use HasFactory;
    protected $fillable = [
        'id_utilisateur',
    ];

    public function getUserType(){
        return 'AgentQHSE';
    }

    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function controleQHSE(){
        return $this->belongsTo(ControleQHSE::class, 'id_utilisateur');
    }
}
