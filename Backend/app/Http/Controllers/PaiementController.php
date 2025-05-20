<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    // 🔹 Afficher tous les paiements
    public function afficherPaiement()
    {
        $paiements = Paiement::with('etudiant')->get();
        return response()->json($paiements);
    }

    // 🔹 Créer un nouveau paiement (fairePaiement)
    public function fairePaiement(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'localisation' => 'required|string',
            'nomBatiment' => 'required|string',
            'typeBatiment' => 'required|in:Cantine,Chambre,Espace',
            'typeLocal' => 'required|string',
            'nomLocal' => 'required|string',
            'typePaiement' => 'required|in:Mensualité,Caution',
            'somme' => 'required|integer|min:0',
            'modePaiement' => 'required|string',
            'date_Paiement' => 'required|date',
            'reference' => 'required|string|unique:paiements,reference',
           
        ]);

        $paiement = Paiement::create($validated);
        return response()->json($paiement, 201);
    }

    // 🔹 Modifier un paiement
    public function modifierPaiement(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);

        $validated = $request->validate([
            'etudiant_id' => 'sometimes|exists:etudiants,id',
            'localisation' => 'sometimes|string',
            'nomBatiment' => 'sometimes|string',
            'typeBatiment' => 'sometimes|in:Cantine,Pavillon,Autre',
            'typeLocal' => 'sometimes|,string',
            'nomLocal' => 'nullable|string',
            'typePaiement' => 'sometimes|in:Mensualité,Caution',
            'somme' => 'sometimes|integer|min:0',
            'modePaiement' => 'sometimes|string',
            'reference' => 'sometimes|string|unique:paiements,reference,' . $paiement->id,
            
        ]);

        $paiement->update($validated);
        return response()->json($paiement);
    }

    // 🔹 Supprimer un paiement
    public function supprimerPaiement($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();
        return response()->json(['message' => 'Paiement supprimé avec succès']);
    }
}
