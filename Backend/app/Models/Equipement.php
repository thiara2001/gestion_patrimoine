<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    /** @use HasFactory<\Database\Factories\EquipementFactory> */
    use HasFactory;
     protected $fillable = [
        'id_site',
        'nom',
    ];
    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
}
