<?php

namespace App\Http\Controllers;

use App\Models\ReservationCantine;
use Illuminate\Http\Request;

class ReservationCantineController extends Controller
{
    // Lister toutes les réservations
    public function index()
    {
        return response()->json(ReservationCantine::all(), 200);
    }

    // Créer une nouvelle réservation
    public function faireReservation(Request $request)
    {
        $validated = $request->validate([
            'id_utilisateur' => 'required|integer|exists:utilisateurs,id',
            'id_site' => 'required|integer|exists:sites,id',
            'description' => 'required|string',
            'choixSite' => 'required|string',
            'motifDemande' => 'required|string',
            'produitouservice' => 'required|string',
            'document' => 'required|string',
            'qualiteQHSE' => 'required|string',
        ]);

        $reservation = ReservationCantine::create($validated);

        return response()->json([
            'message' => 'Réservation à la cantine créée avec succès.',
            'reservation' => $reservation
        ], 201);
    }

    // Afficher une réservation spécifique
    public function AfficherReservation($id)
    {
        $reservation = ReservationCantine::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée.'], 404);
        }
        return response()->json($reservation, 200);
    }

    // Mettre à jour une réservation
    public function modifierReservation(Request $request, $id)
    {
        $reservation = ReservationCantine::find($id);
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
        $reservation = ReservationCantine::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée.'], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée.']);
    }
}
