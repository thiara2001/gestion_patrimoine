<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\Intervention;
use App\Models\Technicien;
use App\Http\Requests\StoreTechnicienRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\View\Components\Alert;

class TechnicienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function consulterAlerte()
    {
        $technicien = Auth::user();

        $alertes = Alerte::where('id_technicien', $technicien->id)
        ->where('typeAlerte', 'maintenance')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'alertes' => $alertes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
  public function marquerAlerte($id)
    {
        $alerte = Alerte::findOrFail($id);

        if ($alerte->id_technicien!== Auth::id()){
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

    /**
     * Store a newly created resource in storage.
     */
    public function traiteIntervention(StoreTechnicienRequest $request)
    {
        $technicien = Auth::user();

        $data = $request->validate([
            'id_equipement' => 'required|exists:equipements,id',
            'descriptionProbleme' => 'required|string',
            'actionEffectue' => 'required|string',
            'statut' => 'required|string|in:en_cours,resolue',
            'observations' => 'nullable|string',
            'dateIntervention' => 'required|date'
        ]);

         // Vérifier si une maintenance est déjà en cours pour cet équipement
        $interventionExistante = Intervention::where('id_equipement', $data['id_equipement'])
            ->where('statut', 'en_cours')
            ->first();
            
        if ($interventionExistante && $data['statut'] === 'en_cours') {
            return response()->json([
                'message' => 'Une maintenance est déjà en cours pour cet équipement.',
                'maintenance_existante' => $interventionExistante
            ], 400);
        }

        $intervention = new Intervention();
        $intervention->id_technicien = $technicien->id;
        $intervention->id_equipement = $data['id_equipement'];
        $intervention->descriptionProbleme = $data['descriptionProbleme'];
        $intervention->actionEffectue = $data['actionEffectue'];
        $intervention->statut = $data['statut'];
        $intervention->observations = $data['observations'];
        $intervention->dateIntervention = $data['dateIntervention'];
        $intervention->save();

        return response()->json([
            'message' => 'Intervention enregistre',
            'intervention' => $intervention
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function historiqueIntervention()
    {
        $technicien = Auth::user();

        $interventions = Intervention::where('id_technicien', $technicien->id)
        ->with(['equipement'])
        ->orderBy('dateIntervention', 'desc')
        ->get();

        return response()->json([
            'interventions' => $interventions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detailIntervention($id_intervention)
    {
        $technicien = Auth::user();

        $intervention = Intervention::where('id', $id_intervention)
        ->where('id_technicien', $technicien->id)
        ->with(['equipement'])
        ->firstOrFail();

        return response()->json([
            'intervention' => $intervention
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateMaintenance(Request $request, $id_intervention)
    {
        $technicien = Auth::user();
        
        $intervention = Intervention::where('id', $id_intervention)
            ->where('id_technicien', $technicien->id)
            ->where('statut', 'en_cours')
            ->firstOrFail();
            
        $validatedData = $request->validate([
            'actionEffectue' => 'nullable|string',
            'statut' => 'nullable|string|in:en_cours,terminée,impossible',
            'observations' => 'nullable|string',
        ]);
        
        // Mettre à jour les champs de la maintenance
        if (isset($validatedData['actionEffectue'])) {
            $intervention->actionEffectue = $validatedData['actionEffectue'];
        }
        
        if (isset($validatedData['observations'])) {
            $intervention->observations = $validatedData['observations'];
        }
        
        if (isset($validatedData['statut'])) {
            $intervention->statut = $validatedData['statut'];
        }
        
        $intervention->save();
        
        return response()->json([
            'message' => 'Maintenance mise à jour avec succès',
            'intervention' => $intervention
        ]);
    }

   
}
