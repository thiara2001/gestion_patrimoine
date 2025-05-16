<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationCantine extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationCantineFactory> */
    use HasFactory;
     protected $fillable = [
        'id_utilisateur',
        'id_site',
        'description',
        'choixSite',
        'motifDemande',
        'produitouservice',
        'document',
        'qualiteQHSE'
    ];
    public function affectation()
    {
        return $this->hasMany(Affectation::class);
    }
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }
     public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
}
