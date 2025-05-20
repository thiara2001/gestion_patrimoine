<?php

namespace App\Http\Controllers;

use App\Models\ControleQHSE;
use Illuminate\Http\Request;
use App\Http\Requests\StoreControleQHSERequest;
use App\Http\Requests\UpdateControleQHSERequest;
use Illuminate\Support\Facades\Validator;

class ControleQHSEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rapports = ControleQHSE::all();
        return response()->json($rapports);
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
            'etablissement' => 'required|string',
            'observation' => 'required|string',
            'conclusion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $rapport = ControleQHSE::create($request->all());
        return response()->json($rapport, 201);
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
    public function edit($controleQHSE)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, ControleQHSE $controleQHSE)
    {
        $validator = Validator::make($request->all(), [
            'id_utilisateur' => 'exists:utilisateurs,id',
            'etablissement' => 'string',
            'observation' => 'string',
            'conclusion' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $controleQHSE->update($request->all());
        return response()->json($controleQHSE);
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