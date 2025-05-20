<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Gestionnaire;
use App\Models\ControleQHSE;
use App\Http\Requests\StoreGestionnaireRequest;
use App\Http\Requests\UpdateGestionnaireRequest;
use Illuminate\Http\Request;

class GestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function gereAffectation(Request $request)
    {
        $data = $request->validate([
            'id_utilisateur' => 'required|exists:utilisateurs,id',
            'id_site' => 'required|exists:sites,id',
            'description' => 'required|string',
            'choixSite' => 'required|string',
            'motifDemande' => 'required|string',
            'produitouservice' => 'required|string',
            'document' => 'required|string',
            'qualiteQHSE' => 'required|string'
        ]);

        //Verifie si l'agent a deja verifier
        $qhse = ControleQHSE::where('id_pavillon', $data['id_pavillon'])
        ->whereHas('id_utilisateur', function($query){
            $query->where('role', 'AgentQHSE');
        })
        ->latest()
        ->first();

        //Si le controle est negatif
        if(!$qhse || $qhse->conclusion === 'negatif'){
            return response()->json([
                'message' => 'Controle negatif',
                'success' => false
            ], 422);
        }

        //creer affectation
        $affecter = new Affectation();
        $affecter->id_utilisateur = $data['id_utilisateur'];
        $affecter->id_site = $data['id_site'];
        $affecter->description = $data['description'];
        $affecter->choixSite = $data['choixSite'];
        $affecter->motifDemande = $data['motifDemande'];
        $affecter->produitouservice = $data['produitouservice'];
        $affecter->document = $data['document'];
        $affecter->id_utilisateur = auth()->user()->id;

        return response()->json([
            'message' => 'Candidat affecter',
            'affecter' => $affecter,
            'success'=> true
        ], 201);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function validerPaiement()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function genererRapport(StoreGestionnaireRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function gererUtilisateur(Gestionnaire $gestionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function gererEquipement(Gestionnaire $gestionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function gererReservation(UpdateGestionnaireRequest $request, Gestionnaire $gestionnaire)
    {
        //
    }

    public function genererAlerte(UpdateGestionnaireRequest $request, Gestionnaire $gestionnaire)
    {
        //
    }
}
