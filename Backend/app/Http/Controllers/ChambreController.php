<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use App\Http\Requests\StoreChambreRequest;
use App\Http\Requests\UpdateChambreRequest;

class ChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chambres = Chambre::all();
        return response()->json($chambres);
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
    public function store(StoreChambreRequest $request)
    {
         $validated = $request->validate([
            'id_pavillon' => 'required|exists:pavillons,id',
            'numChambre' => 'required|string|unique:chambres,numChambre',
            'nombreLits' => 'required|integer|min:1',
            'toiletteInterieur' => 'required|boolean',
            'nbreLampe' => 'required|integer|min:0',
            'nombrePrise' => 'required|integer|min:0',
        ]);

        $chambre = Chambre::create($validated);
        return response()->json($chambre, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
         return response()->json($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chambre $chambre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChambreRequest $request, Chambre $chambre)
    {
         $validated = $request->validate([
            'id_pavillon' => 'exists:pavillons,id',
            'numChambre' => 'string|unique:chambres,numChambre,' . $chambre->id,
            'nombreLits' => 'integer|min:1',
            'toiletteInterieur' => 'boolean',
            'nbreLampe' => 'integer|min:0',
            'nombrePrise' => 'integer|min:0',
        ]);

        $chambre->update($validated);
        return response()->json($chambre);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $id->delete();
        return response()->json(null, 204);
    }
}