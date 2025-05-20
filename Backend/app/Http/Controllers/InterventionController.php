<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;

use App\Http\Requests\StoreInterventionRequest;
use App\Http\Requests\UpdateInterventionRequest;
use Illuminate\Support\Facades\Validator;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $interventions = Intervention::all();
        return response()->json($interventions);
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
            'id_utilisateur' => 'required|exists:utilisateurs,id',
            'natureProbleme' => 'required|string',
            'description' => 'required|string',
            'id_site' => 'required|exists:sites,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $intervention = Intervention::create($request->all());
        return response()->json($intervention, 201);
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
    public function edit(Intervention $intervention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intervention $intervention)
    {
        $validator = Validator::make($request->all(), [
        'id_utilisateur' => 'exists:utilisateurs,id',
        'natureProbleme' => 'string',
        'description' => 'string',
        'id_site' => 'exists:sites,id',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $intervention->update($request->all());
    return response()->json($intervention);
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