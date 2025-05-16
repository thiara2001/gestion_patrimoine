<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    /** @use HasFactory<\Database\Factories\ChambreFactory> */
    use HasFactory;
     protected $fillable = [
        'id_pavillon',
        'numChambre',
        'nombreLits',
        'toiletteInterieur',
        'nbreLampe',
        'nombrePrise'
    ];
    public function pavillon()
    {
        return $this->belongsTo(Pavillon::class, 'id_pavillon');
    }
}
