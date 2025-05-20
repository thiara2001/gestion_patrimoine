<?php

namespace App\Http\Controllers;

use App\Models\Commercant;
use App\Models\Paiement;
use App\Models\ReservationCantine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommercantRequest;
use App\Http\Requests\UpdateCommercantRequest;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CommercantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function consulterReservation()
    {
        $commercant = Auth::user();

        $reservations = ReservationCantine::where('id_utilisateur', $commercant->id)
        ->orderBy('created_at', 'desc')->get();

        return response()->json([
            'reservations' => $reservations        
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function fairePaiement(Request $request)
    {
        $commercant = Auth::user();

        $data = $request->validate([
            'id_reservation' => 'required|exists:reservation_cantine_espaces,id',
            'montant' => 'required|numeric|min:0',
            'modePaiement' => 'required|string|in:espece,carte,virement,mobile_money',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $reservation = ReservationCantine::where('id', $data['id_reservation'])
        ->where('id_utilisateur',$commercant->id)
        ->first();

        if(!$reservation){
            return response()->json([
                'message' => 'Reservation non trouvee'
            ], 404);
        }

         // Calculer le reste à payer
        $dejaPayé = Paiement::where('id_cantine', $reservation->id)
            ->where('statut', 'payer')
            ->sum('montant');
            
        $resteAPayer = $reservation->montant_total - $dejaPayé;
        
        if ($resteAPayer <= 0) {
            return response()->json([
                'message' => 'Cette réservation est déjà entièrement payée'
            ], 400);
        }
        
        if ($data['montant'] > $resteAPayer) {
            return response()->json([
                'message' => 'Le montant dépasse le reste à payer (' . $resteAPayer . ')',
                'reste_a_payer' => $resteAPayer
            ], 400);
        }

        $paiement = new Paiement();
        $paiement->id_utilisateur = $commercant->id;
        $paiement->id_cantine = $data['id_reservation'];
        $paiement->localisation = 'localisation';
        $paiement->nomBatiment = 'nomBatiment';
        $paiement->typeBatiment = 'typeBatiment';
        $paiement->somme = $data['montant'];
        $paiement->modePaiement = $data['modePaiement'];
        $paiement->date_Paiement = now();
        $paiement->reference = $data['reference'];
        $paiement->statut = 'en_attente';
        $paiement->save();

         // Mettre à jour le statut de la réservation si nécessaire
        if ($data['montant'] >= $resteAPayer) {
            $reservation->statut_paiement = 'payée';
            $reservation->save();
        } else if ($dejaPayé + $data['montant'] > 0) {
            $reservation->statut_paiement = 'partiellement_payée';
            $reservation->save();
        }
        
        return response()->json([
            'message' => 'Paiement enregistré avec succès et en attente de validation',
            'paiement' => $paiement,
            'reste_a_payer' => $resteAPayer - $data['montant']
        ], 201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function consulterPaiement()
    {
        $commercant = Auth::user();

        $paiements = Paiement::where('id_utilisateur', $commercant->id)
        ->orderBy('date_paiement', 'desc')
        ->get();

        return response()->json([
            'paiments'=>$paiements
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function faireReservation(Request $request)
    {
        $commercant = Auth::user();

        $data = $request->validate([
            'typeEspace' => 'required|string|in:cantine,espace',
            'id_espace' => 'required|integer',
            'motif' => 'required|string',
            'description' => 'nullable|string',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

         // Gérer le téléchargement du fichier
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('reservations', 'public');
        } else {
            $path = null;
        }

        $reservation = new ReservationCantine;
        $reservation->id_utilisateur = $commercant->id;
        $reservation->id_site = $data['id_espace'];
        $reservation->description = $data['description'];
        $reservation->choixSite = 'choixSite';
        $reservation->motifDemande = $data['motif'];
        $reservation->produitouservice = 'produitouservice';
        $reservation->document = $path;
        $reservation->qualiteQHSE = 'qualiteQHSE';
        $reservation->statutPaiement = 'en_attente';
        $reservation->save();
  
        return response()->json([
            'message' => 'Reservation effectue',
            'reservation' => $reservation
        ], 201);
    }


   
}
