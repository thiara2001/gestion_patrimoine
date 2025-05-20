<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
class Technicien extends Utilisateur
{
    use HasFactory;

    protected $fillable = [
        'id_domaine',
        'localisation',
    ];

    public function getUserType(){
        return 'Technicien';
    }


    public function domaine(){
        return $this->belongsTo(Domaine::class, 'id_domaine');
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'id_technicien');
    }

    public function alertes()
    {
        return $this->hasMany(Alerte::class, 'id_technicien');
    }
}


