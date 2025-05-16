<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method void login()
 * @method void logout()
 */

abstract class Utilisateur extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UtilisateurFactory> */
    use Notifiable;
   
    public function alerte(){
        return $this->hasMany(Alerte::class);
    }
    public function resercationCantine()
    {
        return $this->hasMany(ReservationCantine::class);
    }
    public function resercationPavillon()
    {
        return $this->hasMany(ReservationPavillon::class);
    }
    public function contrat()
    {
        return $this->hasMany(Contrat::class);
    }
    public function controleQHSE()
    {
        return $this->hasMany(ControleQHSE::class);
    }
    public function intervention()
    {
        return $this->hasMany(Intervention::class);
    }
    public function rapport()
    {
        return $this->hasMany(Rapport::class);
    }
    public function reclamation()
    {
        return $this->hasMany(Reclamation::class);
    }
    public function paiement()
    {
        return $this->hasMany(Paiement::class);
    }
}
