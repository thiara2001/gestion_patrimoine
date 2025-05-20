<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    // Lister tous les contrats
    public function index()
    {
        return response()->json(Contrat::all());
    }

    // Créer un contrat
    public function creerContrat(Request $request)
    {
        $validated = $request->validate([
            'id_utilisateur' => 'required|integer|exists:utilisateurs,id',
            'id_paiement' => 'required|integer|exists:paiements,id',
            'localisation' => 'required|string',
            'nomlocal' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:dateDebut',
            'montant_loyer' => 'required|numeric',
            'montant_caution' => 'required|numeric',
            
           
            
        ]);

        $contrat = Contrat::create($validated);
        return response()->json($contrat, 201);
    }

    // Afficher un contrat spécifique
    public function affichercontrat($id)
    {
        $contrat = Contrat::find($id);

        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé'], 404);
        }

        return response()->json($contrat);
    }

    // Modifier un contrat
    public function modifiercontrat(Request $request, $id)
    {
        $contrat = Contrat::find($id);
        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé'], 404);
        }

        $validated = $request->validate([
            'id_utilisateur' => 'sometimes|exists:utilisateurs,id',
            'id_paiement' => 'sometimes|exists:paiements,id',
            'localisation' => 'sometimes|required|string',
            'nomlocal' => 'sometimes|required|string',
            'date_debut' => 'sometimes|required|date',
            'date_fin' => 'sometimes|required|date|after_or_equal:dateDebut',
            'montant_loyer' => 'sometimes|required|numeric',
            'montant_caution' => 'sometimes|required|numeric',
           
        ]);

        $contrat->update($validated);
        return response()->json($contrat);
    }

    // Supprimer un contrat
    public function supprimerContrat($id)
    {
        $contrat = Contrat::find($id);
        if (!$contrat) {
            return response()->json(['message' => 'Contrat non trouvé'], 404);
        }

        $contrat->delete();
        return response()->json(['message' => 'Contrat supprimé avec succès']);
    }
}
