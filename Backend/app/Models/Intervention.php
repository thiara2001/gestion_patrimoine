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

    public function batiment(){
        return $this->belongsTo(Batiment::class, 'id_sitz');
    }
}
