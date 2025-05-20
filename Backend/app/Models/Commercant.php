<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commercant extends Utilisateur
{
    /** @use HasFactory<\Database\Factories\CommercantFactory> */
    use HasFactory;
    
    protected $fillable = [
        'numeroCi'
    ];

    public function getUserType(){
        return 'Commercant';
    }

 

    public function paiement()
    {
        return $this->hasMany(Paiement::class);
    }

    public function reclamation()
    {
        return $this->hasMany(Reclamation::class);
    }

     public function reservations()
    {
        return $this->hasMany(ReservationCantine::class, 'id_utilisateur');
    }
}
