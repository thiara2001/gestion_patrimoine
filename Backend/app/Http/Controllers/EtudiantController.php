<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use App\Models\Domaine;
use App\Models\Filiere;
use App\Models\Paiement;
use App\Models\ReservationCantine;
use App\Models\ReservationPavillon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function consulterReservation()
    {
        $etudiant = Auth::user();

        $reservations = ReservationPavillon::where('id_utlisateur', $etudiant->id)
        ->with(['pavillon', 'paiements'])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'reservations' => $reservations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function faireReservation(Request $request)
    {
        $etudiant = Auth::user();

        $data = $request->validate([
            'id_pavillon' => 'required|exists:pavillon,id',
            'nomPavillon' => 'required|string',
            'nomChambre' => 'required|string',
            'nombreCredit' => 'required|integer',
            'moyenneAnnuel' => 'required|integer',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

         // Verifier si l'etudiant a deja une reservation active
        $reservationActive = ReservationPavillon::where('id_utilisateur', $etudiant->id)
            ->where(function($query) {
                $query->where('statut', 'approuvee')
                    ->orWhere('statut', 'en_attente');
            })
            ->first();
            
        if ($reservationActive) {
            return response()->json([
                'message' => 'Vous avez déjà une réservation active ou en attente.',
                'reservation_active' => $reservationActive
            ], 400);
        }

         // Gérer le téléchargement du fichier
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('reservations/pavillons', 'public');
        } else {
            $path = null;
        }

        $reservation = new ReservationPavillon();
        $reservation->id_utilisateur = $etudiant->id;
        $reservation->id_pavillon = $data['id_pavillon'];
        $reservation->niveauEtude = 'niveauEtude';
        $reservation->nomPavillon = $data['nomPavillon'];
        $reservation->nomChambre = $data['nomChambre'];
        $reservation->nombreCredit = $data['nombreCredit'];
        $reservation->moyenneAnnuel = $data['moyenneAnnuel'];
        $reservation->document = $data['document'];
        $reservation->statut = 'en_attente';
        $reservation->statutPaiement = 'non_payee';
        $reservation->save();

        return response()->json([
            'message'=>'Reservation enregistree',
            'reservation'=>$reservation
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
     public function fairePaiement(Request $request)
    {
        $etudiant = Auth::user();

        $data = $request->validate([
            'id_reservation' => 'required|exists:reservation_cantine_espaces,id',
            'montant' => 'required|numeric|min:0',
            'modePaiement' => 'required|string|in:espece,carte,virement,mobile_money',
            'reference' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $reservation = ReservationPavillon::where('id', $data['id_reservation'])
        ->where('id_utilisateur',$etudiant->id)
        ->first();

        if(!$reservation){
            return response()->json([
                'message' => 'Reservation non trouvee'
            ], 404);
        }

         // Calculer le reste à payer
        $dejaPayé = Paiement::where('id_pavillon', $reservation->id)
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
        $paiement->id_utilisateur = $etudiant->id;
        $paiement->id_pavillon = $reservation->id;
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
     * Display the specified resource.
     */
    
    public function consulterPaiement()
    {
        $etudiant = Auth::user();

        $paiements = Paiement::where('id_utilisateur', $etudiant->id)
        ->orderBy('date_paiement', 'desc')
        ->get();

        return response()->json([
            'paiments'=>$paiements
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function VoirDomaineFiliere()
    {
        $etudiant = Auth::user();

        
        $filiere = Filiere::find($etudiant->id_filiere);

        return response()->json([
           
            'filiere' => $filiere
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
   

    
}
