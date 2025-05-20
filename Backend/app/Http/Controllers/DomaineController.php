<?php

namespace App\Http\Controllers;

use App\Models\Domaine;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateDomaineRequest;

class DomaineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domaines = Domaine::all();

        return response()->json([
            'domaines' => $domaines
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'nomDomaine' => 'required|string|max:255|unique:domaines',
        ]);

        $domaine = new Domaine();
        $domaine->nomDomaine = $data['nomDomaine'];

        return response()->json([
            'message' => 'Domaine cree',
            'filiere' => $domaine
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $domaine = Domaine::findOrFail($id);

        return response()->json([
            'domaine' => $domaine
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
       public function updateDomaine(Request $request, $id)
    {
       $domaine = Domaine::find($id);

        if (!$domaine) {
            return response()->json([
                'success' => false,
                'message' => 'Domaine non trouvé'
            ], 404);
        }

        $data = $request->validate([
            'nomDomaine' => 'required|string|max:255|unique:domaines',
        ]);

          $domaine->update([
            'nomDomaine' => $request->nomDomaine,
        ]);

        return response()->json([
            'message' => 'Domaine cree',
            'domaine' => $domaine
        ], 201);
    }

     public function destroyDomaine($id)
    {
        $domaine = Domaine::find($id);

        if (!$domaine) {
            return response()->json([
                'success' => false,
                'message' => 'Domaine non trouvé'
            ], 404);
        }

        if ($domaine->techniciens()->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer ce domaine car des étudiants y sont associé à des technicien(s)'
            ], 400);
        }
        
        $domaine->delete();
        
        return response()->json([
            'message' => 'Domaine supprimée avec succès'
        ]);
    }

     public function getTechniciens($id)
    {
        $domaine = Domaine::find($id);
        
        $techniciens = $domaine->techniciens()->get();
        
        return response()->json([
            'filiere' => $domaine->nomDomaine,
            'etudiants' => $techniciens
        ]);
    }

    public function getStatistiques($id)
    {
        $domaine = Domaine::find($id);
        
        // Nombre total de domaine
        $totalTechnicien = $domaine->techniciens()->count();
        
        // Répartition par nom
        $parNom = $domaine->techniciens()
            ->selectRaw('nomDomaine, count(*) as nombre')
            ->groupBy('nomDomaine')
            ->get();
            
       
        return response()->json([
            'domaine' => $domaine->nomDomaine,
            'total_technicien' => $totalTechnicien,
            'par_nom' => $parNom
        ]);
    }
}
