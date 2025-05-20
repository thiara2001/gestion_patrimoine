<?php

namespace App\Mail;

use App\Models\Reclamation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReclamationEnvoyee extends Mailable
{
    use Queueable, SerializesModels;

    public $reclamation;

    public function __construct(Reclamation $reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function build()
    {
        return $this->subject('Nouvelle Réclamation Reçue')
            ->view('emails.reclamation');
    }
}
