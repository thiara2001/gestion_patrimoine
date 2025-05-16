<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercant extends Utilisateur
{
    /** @use HasFactory<\Database\Factories\CommercantFactory> */
    use HasFactory;
    
    protected $fillable = [
        'id_utilisateur',
        'numeroCi'
    ];

    public function getUserType(){
        return 'Commercant';
    }

    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
}
