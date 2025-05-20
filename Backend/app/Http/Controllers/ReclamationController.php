<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Mail;

class ReclamationController extends Controller
{
    // Liste toutes les réclamations
    public function index()
    {
        $reclamations = Reclamation::all();
        return response()->json($reclamations);
    }

    // Crée une nouvelle réclamation et envoie un mail
    public function store(Request $request)
    {
        $data = $request->validate([
            'idUtilisateur' => 'nullable|exists:utilisateurs,id',
            'localisation' => 'required|string|max:255',
            'nomLocal' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $reclamation = Reclamation::create($data);

        // Contenu de l'e-mail brut
        $message = "Nouvelle réclamation reçue :\n\n";
        $message .= "Utilisateur : " . ($reclamation->idUtilisateur ?? 'Non spécifié') . "\n";
        $message .= "Localisation : " . $reclamation->localisation . "\n";
        $message .= "Nom du local : " . $reclamation->nomLocal . "\n";
        $message .= "Description : " . $reclamation->description . "\n";

        // Envoi du mail
        Mail::raw($message, function ($mail) {
            $mail->to('thiamthiara8@gmail.com')
                 ->subject('Nouvelle réclamation');
        });

        return response()->json(['message' => 'Réclamation envoyée avec succès.'], 201);
    }

    // Affiche une seule réclamation
    public function show($id)
    {
        $reclamation = Reclamation::find($id);

        if (!$reclamation) {
            return response()->json(['message' => 'Réclamation non trouvée.'], 404);
        }

        return response()->json($reclamation);
    }

    // Met à jour une réclamation existante
    public function update(Request $request, $id)
    {
        $reclamation = Reclamation::find($id);

        if (!$reclamation) {
            return response()->json(['message' => 'Réclamation non trouvée.'], 404);
        }

        $data = $request->validate([
            'localisation' => 'sometimes|required|string|max:255',
            'nomLocal' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);

        $reclamation->update($data);

        return response()->json(['message' => 'Réclamation mise à jour avec succès.']);
    }

    // Supprime une réclamation
    public function destroy($id)
    {
        $reclamation = Reclamation::find($id);

        if (!$reclamation) {
            return response()->json(['message' => 'Réclamation non trouvée.'], 404);
        }

        $reclamation->delete();

        return response()->json(['message' => 'Réclamation supprimée avec succès.']);
    }
}
