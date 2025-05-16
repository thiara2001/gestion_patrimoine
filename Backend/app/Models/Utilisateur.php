<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

abstract class Utilisateur extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'sexe',
        'age',
        'adresse',
        'telephone',
        'role',
    
    ];

    abstract public function getUserType();

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function technicien(){
        return $this->hasMany(Technicien::class, 'id_utilisateur');
    }

    public function gestionnaire(){
        return $this->hasMany(Gestionnaire::class, 'id_utilisateur');
    }

    public function etudiant(){
        return $this->hasMany(Etudiant::class, 'id_utilisateur');
    }

    public function agentQHSE(){
        return $this->hasMany(AgentQHSE::class, 'id_utilisateur');
    }

    public function commercant(){
        return $this->hasMany(Commercant::class, 'id_utilisateur');
    }

    
}