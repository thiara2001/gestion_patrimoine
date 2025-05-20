<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affectation;
use App\Models\ReservationCantine;
use App\Models\ReservationPavillon;

class AffectationController extends Controller
{
    // Liste toutes les affectations
    public function index()
    {
        return response()->json(Affectation::all());
    }

    // Créer une nouvelle affectation
    public function creerAffectation(Request $request)
    {
        $validated = $request->validate([
            'id_reservationCantine' => 'nullable|exists:reservation_cantines,id',
            'id_reservationPavillon' => 'nullable|exists:reservation_pavillons,id',
            'date_affectation' => 'required|date',
        ]);

        if (!$validated['id_reservationCantine'] && !$validated['id_reservationPavillon']) {
            return response()->json(['error' => 'Une réservation de cantine ou de pavillon est requise.'], 422);
        }

        $affectation = Affectation::create($validated);

        return response()->json($affectation, 201);
    }

    // Afficher une affectation par son ID
    public function afficherAffectation($id)
    {
        $affectation = Affectation::find($id);
        if (!$affectation) {
            return response()->json(['error' => 'Affectation non trouvée'], 404);
        }

        return response()->json($affectation);
    }

    // Mettre à jour une affectation
    public function modifierAffectation(Request $request, $id)
    {
        $affectation = Affectation::find($id);
        if (!$affectation) {
            return response()->json(['error' => 'Affectation non trouvée'], 404);
        }

        $validated = $request->validate([
            'id_reservationCantine' => 'nullable|exists:reservation_cantines,id',
            'id_reservationPavillon' => 'nullable|exists:reservation_pavillons,id',
            'date_affectation' => 'required|date',
        ]);

        $affectation->update($validated);

        return response()->json($affectation);
    }

    // Supprimer une affectation
    public function supprimerAffectation($id)
    {
        $affectation = Affectation::find($id);
        if (!$affectation) {
            return response()->json(['error' => 'Affectation non trouvée'], 404);
        }

        $affectation->delete();
        return response()->json(['message' => 'Affectation supprimée avec succès']);
    }
}
