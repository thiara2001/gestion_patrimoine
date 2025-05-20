<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReclamationEnvoyee extends Mailable
{
    use Queueable, SerializesModels;

    public $reclamation;

    public function __construct($reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function build()
    {
        return $this->subject('Nouvelle réclamation reçue')
                    ->text('emails.empty') // Option 1: fichier vide pour le "text"
                    ->with([
                        'reclamation' => $this->reclamation,
                    ]);
    }
}
