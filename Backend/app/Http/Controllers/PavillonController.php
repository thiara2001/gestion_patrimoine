<?php

namespace App\Http\Controllers;

use App\Models\Pavillon;
use Illuminate\Http\Request;

use App\Http\Requests\StorePavillonRequest;
use App\Http\Requests\UpdatePavillonRequest;
use Illuminate\Support\Facades\Validator;

class PavillonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pavillons = Pavillon::all();
        return response()->json($pavillons);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_site' => 'required|exists:sites,id',
            'nomPavillon' => 'required|string|unique:pavillons,nomPavillon',
            'nombreChambre' => 'required|integer|min:0',
            'nombreSalle' => 'required|integer|min:0',
            'nombreToilette' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pavillon = Pavillon::create($request->all());

        return response()->json($pavillon, 201);
    }

    // Afficher un pavillon spécifique
    public function show($id)
    {
        return response()->json($id);
    }

    

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pavillon $pavillon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pavillon $pavillon)
    {
         $validator = Validator::make($request->all(), [
            'id_site' => 'exists:sites,id',
            'nomPavillon' => 'string|unique:pavillons,nomPavillon,' . $pavillon->id,
            'nombreChambre' => 'integer|min:0',
            'nombreSalle' => 'integer|min:0',
            'nombreToilette' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pavillon->update($request->all());

        return response()->json($pavillon);
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