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
        'id_site',
        'description',
        'natureProbleme',
        
    ];
   
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisteur');
    }
     public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
}
