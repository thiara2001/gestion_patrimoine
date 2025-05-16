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

    //Connexion des utilisateurs
    public function login($email, $password){
        if($this->email === $email && $this->verifierPassword($password)){
            //Connexion dans la base de donne
            $this->est_connecter = true;
            $this->dernierConnexion = now();
            $this->save();

            return true;
        }

        return false;
    }

    /**
     * Deconnexion des utilisateurs
     * 
     * @return bool
     */
    public function logout(){
        $this->est_connecter = false;
        $this->save();

        return true;
    }

    /**
     * Verifier mot de passe
     * 
     * @param string $password
     * @return bool
     */
    public function verifierPassword($password){
        return password_verify($password, $this->password);
    }

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
}
