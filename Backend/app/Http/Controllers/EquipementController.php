<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateEquipementRequest;
use Illuminate\Support\Facades\Validator;

class EquipementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipements = Equipement::all();
        return response()->json($equipements);
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
            'nom' => 'required|string|unique:equipements,nom',
            'etablissement' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $equipement = Equipement::create($request->all());

        return response()->json($equipement, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipement $equipement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipement $equipement)
    {
         $validator = Validator::make($request->all(), [
            'nom' => 'string|unique:equipements,nom,' . $equipement->id,
            'etablissement' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $equipement->update($request->all());

        return response()->json($equipement);
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