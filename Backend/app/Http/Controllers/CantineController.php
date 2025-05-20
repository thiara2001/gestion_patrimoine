<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Cantine;
use App\Http\Requests\StoreCantineRequest;
use App\Http\Requests\UpdateCantineRequest;
use Illuminate\Support\Facades\Validator;

class CantineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cantines = Cantine::all();
        return response()->json($cantines);
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
            'numeroCantine' => 'required|string|unique:cantines,numeroCantine',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cantine = Cantine::create($request->all());

        return response()->json($cantine, 201);
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
    public function edit(Cantine $cantine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cantine $cantine)
    {
        $validator = Validator::make($request->all(), [
            'id_site' => 'exists:sites,id',
            'numeroCantine' => 'string|unique:cantines,numeroCantine,' . $cantine->id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cantine->update($request->all());

        return response()->json($cantine);
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