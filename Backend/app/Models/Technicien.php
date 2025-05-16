<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
class Technicien extends Utilisateur
{
    use HasFactory;

    protected $fillable = [
        'id_utilisateur',
        'id_domaine',
        'localisation',
    ];

    public function getUserType(){
        return 'Technicien';
    }

    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function domaine(){
        return $this->belongsTo(Domaine::class, 'id_domaine');
    }
}


