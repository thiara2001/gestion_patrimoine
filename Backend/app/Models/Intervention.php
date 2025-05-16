<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    /** @use HasFactory<\Database\Factories\InterventionFactory> */
    use HasFactory;

    protected $fillable = [
        'id_utilisateur',
        'natureProbleme',
        'description',
        'id_site'
    ];

    public function site(){
        return $this->belongsTo(Site::class, 'id_site');
    }
   
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }
    
}
