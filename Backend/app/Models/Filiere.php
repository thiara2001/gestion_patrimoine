<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    /** @use HasFactory<\Database\Factories\FiliereFactory> */
    use HasFactory;
     protected $fillable = [
        'nomFiliere'
    ];
    public function etudiant()
    {
        return $this->hasMany(Etudiant::class);
    }
}
