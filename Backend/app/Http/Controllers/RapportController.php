<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    // 🔍 Lister tous les rapports
    public function index()
    {
        return response()->json(Rapport::all());
    }

    // 📄 Afficher un rapport spécifique
    public function afficherRapport($id)
    {
        $rapport = Rapport::find($id);
        if (!$rapport) {
            return response()->json(['message' => 'Rapport non trouvé'], 404);
        }
        return response()->json($rapport);
    }

    // 📝 Créer un nouveau rapport
    public function creerRapport(Request $request)
    {
        $validated = $request->validate([
            'idUtilisateur' => 'required|integer|exists:utilisateurs,id',
            'typeRapport' => 'required|string',
            'contenu' => 'required|string',
            'dateGeneration' => 'required|date',
        ]);

        $rapport = Rapport::create($validated);
        return response()->json($rapport, 201);
    }

    // ✏️ Mettre à jour un rapport existant
    public function modifierRapport(Request $request, $id)
    {
        $rapport = Rapport::find($id);
        if (!$rapport) {
            return response()->json(['message' => 'Rapport non trouvé'], 404);
        }

        $rapport->update($request->only(['typeRapport', 'contenu', 'dateGeneration']));
        return response()->json($rapport);
    }

    // 🗑️ Supprimer un rapport
    public function supprimerRapport($id)
    {
        $rapport = Rapport::find($id);
        if (!$rapport) {
            return response()->json(['message' => 'Rapport non trouvé'], 404);
        }

        $rapport->delete();
        return response()->json(['message' => 'Rapport supprimé avec succès']);
    }
}
