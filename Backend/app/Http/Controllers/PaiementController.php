<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Auth;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
      protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }
    // 🔹 Afficher tous les paiements
    public function afficherPaiement()
    {
        $paiements = Paiement::with('etudiant')->get();
        return response()->json($paiements);
    }

    // 🔹 Créer un nouveau paiement (fairePaiement)
    public function fairePaiement(Request $request)
{
    $request->validate([
        'localisation' => 'required',
        'nomBatiment' => 'required',
        'typeBatiment' => 'required',
        'nomLocal' => 'required',
        'typePaiement' => 'required',
        'somme' => 'required|numeric',
        'modePaiement' => 'required',
        'date_Paiement' => 'required|date',
        'reference' => 'required|unique:paiements,reference',
    ]);

    $utilisateur = Auth::user(); // Assurez-vous que l'utilisateur est connecté

    if (!$utilisateur) {
        return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
    }

    $paiement = Paiement::create([
        'id_utilisateur' => $utilisateur->id, // ici on ajoute l'id_utilisateur
        'localisation' => $request->localisation,
        'nomBatiment' => $request->nomBatiment,
        'typeBatiment' => $request->typeBatiment,
        'nomLocal' => $request->nomLocal,
        'typePaiement' => $request->typePaiement,
        'somme' => $request->somme,
        'modePaiement' => $request->modePaiement,
        'date_Paiement' => $request->date_Paiement,
        'reference' => $request->reference,
    ]);

    return response()->json($paiement, 201);
}


    // 🔹 Modifier un paiement
    public function modifierPaiement(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);

        $validated = $request->validate([
            'id_utilisateur' => 'sometimes|exists:utilisateurs,id',
            'localisation' => 'sometimes|string',
            'nomBatiment' => 'sometimes|string',
            'typeBatiment' => 'sometimes|string',
            'typeLocal' => 'sometimes|in:Cantine,Chambre',
            'nomLocal' => 'nullable|string',
            'typePaiement' => 'sometimes|in:Mensualité,Caution',
            'somme' => 'sometimes|integer|min:0',
            'modePaiement' => 'sometimes|string',
            'date_Paiement' => 'sometimes|date',
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
