<?php

namespace App\Http\Controllers;

use App\Models\Espace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $espaces = Espace::all();
        return response()->json($espaces);
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
            'localisation' => 'required|string|max:255',
            'superficie' => 'required|numeric|min:0',
            ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $espace = Espace::create($request->all());

        return response()->json($espace, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Espace $espace)
    {
        return response()->json($espace);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Espace $espace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Espace $espace)
    {
        $validator = Validator::make($request->all(), [
            'id_site' => 'exists:sites,id',
            'localisation' => 'string|max:255',
            'superficie' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $espace->update($request->all());

        return response()->json($espace);
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