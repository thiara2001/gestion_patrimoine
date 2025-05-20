<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    /** @use HasFactory<\Database\Factories\AffectationFactory> */
    use HasFactory;
    protected $fillable=[
        'id_reservationCantine',
        'id_reservationPavillon',
        'date_affectation'
    ];
    
    public function reservationCantine()
    {
        return $this->belongsTo(ReservationCantine::class, 'id_reservationCantine');
    }
   public function utilisateur()
   {
        return $this->belongsTo(Utilisateur::class);
   }

    public function gestionnaire()
    {
        return $this->belongsTo(Utilisateur::class, 'gestionnaire_id');
    }


}
