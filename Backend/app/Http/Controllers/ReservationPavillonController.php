<?php

namespace App\Http\Controllers;

use App\Models\ReservationPavillon;
use Illuminate\Http\Request;

class ReservationPavillonController extends Controller
{
    // Lister toutes les réservations
    public function index()
    {
        return response()->json(ReservationPavillon::all(), 200);
    }

    // Créer une nouvelle réservation
   public function faireReservation(Request $request)
{
    $validated = $request->validate([
        'id_utilisateur' => 'sometimes|exists:utilisateurs,id',
        'id_site' => 'sometimes|exists:sites,id',
        'niveauEtude' => 'required|string',
        'nomPavillon' => 'required|string',
        'nomChambre' => 'required|string',
        'nombreCredit' => 'required|numeric',
        'moyenneAnnuel' => 'required|numeric',
        'document' => 'required|string', // ou file si c'est un upload
    ]);

    // Règle métier : refuser si moyenne < 12 et crédits < 60
    if ($validated['moyenneAnnuel'] < 12 || $validated['nombreCredit'] < 60) {
        return response()->json([
            'message' => "L'étudiant ne peut pas réserver une chambre car sa moyenne est inférieure à 12 ou ses nombres de crédits sont inférieurs à 60."
        ], 403);
    }

    $reservation = ReservationPavillon::create($validated);

    return response()->json([
        'message' => 'Réservation créée avec succès.',
        'reservation' => $reservation
    ], 201);
}


    // Afficher une réservation spécifique
    public function afficherReservation($id)
    {
        $reservation = ReservationPavillon::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée.'], 404);
        }
        return response()->json($reservation, 200);
    }

    // Mettre à jour une réservation
    public function ModifierReservation(Request $request, $id)
    {
        $reservation = ReservationPavillon::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée.'], 404);
        }

        $reservation->update($request->all());

        return response()->json([
            'message' => 'Réservation mise à jour.',
            'reservation' => $reservation
        ]);
    }

    // Supprimer une réservation
    public function supprimerReservation($id)
    {
        $reservation = ReservationPavillon::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée.'], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée.']);
    }
}
