<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Http\Requests\StoreFiliereRequest;
use App\Http\Requests\UpdateFiliereRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filieres = Filiere::all();

        return response()->json([
            'filieres' => $filieres
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if($user->getUserType()!== 'Gestionnaire'){
            return response()->json([
                'message'=>'Action non autorise'
            ], 403);
        }

        $data = $request->validate([
            'nomFiliere' => 'required|string|max:255|unique:filieres, nomFiliere'
        ]);

        $filiere = new Filiere();
        $filiere->nomFiliere = $data['nomFiliere'];

        return response()->json([
            'message' => 'Filiere cree',
            'filiere' => $filiere
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $filiere = Filiere::findOrFail($id);

        return response()->json([
            'filiere' => $filiere
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateFiliere(Request $request, $id)
    {
       $user = Auth::user();

        if($user->getUserType()!== 'Gestionnaire'){
            return response()->json([
                'message'=>'Action non autorise'
            ], 403);
        }

        $filiere = Filiere::findOrFail($id);

        $data = $request->validate([
            'nomFiliere' => 'nullable|string|max:255|unique:filieres, nomFiliere'
        ]);

          // Mettre à jour la filière
        
        if (isset($validatedData['nomFiliere'])) {
            $filiere->nomFiliere = $data['nomFiliere'];
        }

        $filiere->save();

        return response()->json([
            'message' => 'Filiere mis a jour',
            'filiere' => $filiere
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFiliere($id)
    {
        $user = Auth::user();

        if($user->getUserType()!== 'Gestionnaire'){
            return response()->json([
                'message'=>'Action non autorise'
            ], 403);
        }

        $filiere = Filiere::findOrFail($id);

        if ($filiere->etudiants()->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer cette filière car des étudiants y sont associés'
            ], 400);
        }
        
        $filiere->delete();
        
        return response()->json([
            'message' => 'Filière supprimée avec succès'
        ]);
    }

     public function getEtudiants($id)
    {
        $filiere = Filiere::findOrFail($id);
        
        $etudiants = $filiere->etudiants()->get();
        
        return response()->json([
            'filiere' => $filiere->nomFiliere,
            'etudiants' => $etudiants
        ]);
    }

    public function getStatistiques($id)
    {
        $filiere = Filiere::findOrFail($id);
        
        // Nombre total d'étudiants
        $totalEtudiants = $filiere->etudiants()->count();
        
        // Répartition par niveau
        $parNiveau = $filiere->etudiants()
            ->selectRaw('niveau, count(*) as nombre')
            ->groupBy('niveau')
            ->get();
            
        // Répartition par statut de paiement
        $avecPaiement = $filiere->etudiants()
            ->whereHas('paiements', function($query) {
                $query->where('statut', 'approuvé');
            })
            ->count();
            
        $sansPaiement = $totalEtudiants - $avecPaiement;
        
        return response()->json([
            'filiere' => $filiere->nomFiliere,
            'total_etudiants' => $totalEtudiants,
            'par_niveau' => $parNiveau,
            'avec_paiement' => $avecPaiement,
            'sans_paiement' => $sansPaiement
        ]);
    }
}
