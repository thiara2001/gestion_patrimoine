<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReclamationEnvoyee;

class ReclamationController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'idUtilisateur' => 'required|exists:utilisateurs,id',
        'etablissement' => 'required|string',
        'nomLocal' => 'required|string',
        'description' => 'required|string'
    ]);

    $reclamation = Reclamation::create($data);

    // envoyer mail au gestionnaire
    Mail::to('gestionnaire@crous.fr')->send(new ReclamationEnvoyee($reclamation));

    return response()->json(['message' => 'Réclamation envoyée avec succès.'], 201);
}
}
