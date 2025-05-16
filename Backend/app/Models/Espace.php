<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espace extends Model
{
    /** @use HasFactory<\Database\Factories\EspaceFactory> */
    use HasFactory;
     protected $fillable = [
        'id_site',
        'localisation',
        'superficie',
    ];
    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
}
