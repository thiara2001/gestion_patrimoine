<?php

namespace App\Http\Controllers;

use App\Models\AgentQHSE;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAgentQHSERequest;
use App\Http\Requests\UpdateAgentQHSERequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReclamationRepondue;

class AgentQHSEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgentQHSERequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AgentQHSE $agentQHSE)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgentQHSE $agentQHSE)
    {
        //
    }

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
