<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pavillon extends Model
{
    /** @use HasFactory<\Database\Factories\PavillonFactory> */
    use HasFactory;
    protected $fillable = [
        'id_site',
        'nomPavillon',
        'nombreChambre',
        'nombreSalle',
        'nombreToilette'
    ];
    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
    public function chambre()
    {
        return $this->hasMany(Chambre::class);
    }
}
