<?php

namespace App\Http\Controllers;

use App\Models\AgentQHSE;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAgentQHSERequest;
use App\Http\Requests\UpdateAgentQHSERequest;
<<<<<<< HEAD
use App\Models\Alerte;
use App\Models\ControleQHSE;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Uri\Contracts\AuthorityInterface;
=======
use Illuminate\Support\Facades\Mail;
use App\Mail\ReclamationRepondue;
>>>>>>> b9181c07e25e8529735351c48a7d3a7d708ea445

use function Laravel\Prompts\alert;

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

<<<<<<< HEAD
}
=======
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgentQHSERequest $request, AgentQHSE $agentQHSE)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgentQHSE $agentQHSE)
    {
        //
    }
    public function repondre($id, Request $request)
{
    $request->validate([
        'resultat' => 'required|in:favorable,defavorable'
    ]);

    $reclamation = Reclamation::findOrFail($id);
    $reclamation->resultat = $request->resultat;
    $reclamation->save();

    // Envoyer la réponse à l’étudiant (par mail ou messagerie interne)
    Mail::to($reclamation->utilisateur->email)->send(new ReclamationRepondue($reclamation));

    return response()->json(['message' => 'Réponse envoyée.']);
}

}
>>>>>>> b9181c07e25e8529735351c48a7d3a7d708ea445
