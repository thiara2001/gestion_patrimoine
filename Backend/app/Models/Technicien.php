<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technicien extends Model
{
    use HasFactory;

    public function domaine()
    {
        return $this->belongsTo(Domaine::class, 'id_domaine');
    }

}


