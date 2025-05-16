<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControleQHSE extends Model
{
    /** @use HasFactory<\Database\Factories\ControleQHSEFactory> */

    use HasFactory;

     protected $fillable = [
        'id_utilisateur',
    ];
   
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }
   
}
