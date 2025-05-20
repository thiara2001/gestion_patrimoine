<?php

namespace App\Http\Controllers;
use App\Models\site;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatesiteRequest;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::all();
        return response()->json($sites);
    }
    

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'nomSite' => 'required|string',
        'localisation' => 'required|string',
        'typeSite' => 'required|string',
        'id_utilisateur' => 'required|exists:utilisateurs,id',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $site = Site::create($request->all());
    return response()->json($site, 201);
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $site = Site::find($id);

        if (!$site) {
            return response()->json(['message' => 'Site non trouvé'], 404);
        }

        return response()->json($site);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id)

    {
    // Nettoyer le nomSite pour enlever les retours à la ligne
    $nomSiteNettoye = trim(str_replace(["\r", "\n"], '', $request->nomSite));

    $request->merge(['nomSite' => $nomSiteNettoye]);

    $validatedData = $request->validate([
        'nomSite' => 'required|unique:sites,nomSite,' . $id,
        'localisation' => 'required|string',
        'typeSite' => 'required|string',
        'id_utilisateur' => 'required|exists:utilisateurs,id',
    ]);

    $site = Site::find($id);

    if (!$site) {
        return response()->json(['message' => 'Site non trouvé'], 404);
    }

    $site->update($validatedData);

    return response()->json($site);
}


    public function destroy($id)

    {
          $id->delete();
        return response()->json(null, 204);
    }
}