<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cantine extends Model
{
    /** @use HasFactory<\Database\Factories\CantineFactory> */
    use HasFactory;
     protected $fillable = [
        'id_site',
        'numeroCantine',

    ];
    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
}
