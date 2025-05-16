<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class site extends Model
{
    /** @use HasFactory<\Database\Factories\SiteFactory> */
    use HasFactory;
    protected $fillable = [
        'id_utilisateur',
        'localisation',
        'nomSite',
        'typeSite'
    ];
     public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
    public function equipement()
    {
        return $this->hasMany(Equipement::class);
    }
    public function chambre()
    {
        return $this->hasMany(Chambre::class);
    }
    public function pavillon()
    {
        return $this->hasMany(Pavillon::class);
    }
    public function espace()
    {
        return $this->hasMany(Espace::class);
    }
    public function cantine()
    {
        return $this->hasMany(Cantine::class);
    }
    public function resercationCantine()
    {
        return $this->hasMany(ReservationCantine::class);
    }
    public function resercationPavillon()
    {
        return $this->hasMany(ReservationPavillon::class);
    }
    public function intervention()
    {
        return $this->hasMany(Intervention::class);
    }

}
