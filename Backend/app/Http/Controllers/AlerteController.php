<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alerte;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlerteEnvoyeeMail;

class AlerteController extends Controller
{
    // 🔍 Lister toutes les alertes
    public function index()
    {
        return response()->json(Alerte::all());
    }
     // 📝 Créer une nouvelle alerte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_utilisaeur' => 'required|integer|exists:utilisateurs,id', // à adapter si le nom exact de la table diffère
             'nom' => 'required|string',
              'description' => 'required|string',
            'typeAlerte' => 'required|string',
            'destinataire' => 'required|string',
           
        ]);

        $alerte = Alerte::create($validated);
        return response()->json($alerte, 201);
    }
    // 📩 envoyer une alerte (création)
    public function envoyerAlerte(Request $request)
    {
       $details = [
        'id_utilisaeur' => $request->id_utilisaeur,
        'nom' => $request->nom,
        'description' => $request->description,
        'typeAlerte' => $request->typeAlerte,
        'destinataire' => $request->destinataire,
    ];

    Mail::to($request->email)->send(new AlerteEnvoyeeMail($details));

    return response()->json(['message' => 'Email envoyé avec succès']);
}
    

    // 👁️ afficher toutes les alertes
    public function afficherAlerte()
    {
        $alertes = Alerte::all();

        return response()->json([
            'message' => 'Liste des alertes',
            'data' => $alertes
        ]);
    }
     // ✏️ Mettre à jour une alerte
    public function update(Request $request, $id)
    {
        $alerte = Alerte::find($id);
        if (!$alerte) {
            return response()->json(['message' => 'Alerte non trouvée'], 404);
        }

        $alerte->update($request->only(['typeAlerte', 'description', 'idBatiment']));
        return response()->json($alerte);
    }

    // 🗑️ Supprimer une alerte
    public function destroy($id)
    {
        $alerte = Alerte::find($id);
        if (!$alerte) {
            return response()->json(['message' => 'Alerte non trouvée'], 404);
        }

        $alerte->delete();
        return response()->json(['message' => 'Alerte supprimée avec succès']);
    }
}
