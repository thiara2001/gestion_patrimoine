<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestionnaire extends Utilisateur
{
    use HasFactory;

    protected $fillable = [
        'id_utilisateur',
        'roleGestionnaire',
    ];

    public function getUserType(){
        return 'Gestionnaire';
    }

    public function utilisateur(){
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function site(){
        return $this->hasMany(site::class, 'id_utilisateur');
    }

}


