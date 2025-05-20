<?php

namespace App\Http\Controllers;

use App\Models\AgentQHSE;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAgentQHSERequest;
use App\Http\Requests\UpdateAgentQHSERequest;
use App\Models\Alerte;
use App\Models\ControleQHSE;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use League\Uri\Contracts\AuthorityInterface;

class AgentQHSEController extends UtilisateurController
{
    /**
     * Liste des controles realise par le l'agent.
     */
    public function listeDesControle()
    {
        $agent = Auth::user();
        $controles = ControleQHSE::where('id_utilisateur', $agent->id)
                               ->orderBy('created_at', 'desc')
                               ->get();

        return response()->json([
            'controles' => $controles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function faireControle(Request $request)
    {

        $agent = Auth::user();

        $request->validate([
            'localisation' => 'required|string',
            'observation' => 'required|string',
            'conclusion' => 'required|string'
        ]);

        $controle = new ControleQHSE();
        $controle->localisation = $request->localisation;
        $controle->observation = $request->observation;
        $controle->conclusion = $request->conclusion;

        $controle->id_utilisateur = $agent->id;
        $controle->save();

        return response()->json([
            'message' => 'Controle creer avec succes',
            'controle' => $controle
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function voirAlerte()
    {
        $agent = Auth::user();
        $alertes = Alerte::where('id_utilisateur', $agent->id)
        ->where('lu', false)
        ->orderBy('created_at', 'desc')
        ->get();
        return response()->json([
            'alertes'=>$alertes
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function marquerAlerte($id)
    {
        $alerte = Alerte::findOrFail($id);
        $agent = Auth::user();

        if ($alerte->id_agent!== $agent->id){
            return response()->json([
                'message' => 'Vous n\'etes pas autorise'
            ], 403);
        }

        $alerte->lu = true;
        $alerte->save();

        return response()->json([
                'message' => 'Alerte lu'
        ]);
    }

    public function consulterAlerte()
    {
        $agent = Auth::user();

        $alertes = Alerte::where('id_agent', $agent->id)
        ->where('typeAlerte', 'nouvelle Reservation')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'alertes' => $alertes
        ]);
    }


}
