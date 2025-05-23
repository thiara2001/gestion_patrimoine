<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    /** @use HasFactory<\Database\Factories\DomaineFactory> */
    use HasFactory;
      protected $fillable = [
        'nomDomaine'
    ];
    public function technicien()
    {
        return $this->hasMany(Technicien::class);
    }
   
}
