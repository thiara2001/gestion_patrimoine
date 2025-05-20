<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alerte;
use Illuminate\Support\Facades\Mail;
//use App\Mail\AlerteEnvoyeeMail;

class AlerteController extends Controller
{
    // 🔍 Lister toutes les alertes
   public function show($id)
{
    $alerte = Alerte::find($id);

    if (!$alerte) {
        return response()->json(['message' => 'Alerte non trouvée'], 404);
    }

    return response()->json($alerte, 200);
}
    // 📩 envoyer une alerte (création)
    public function envoyerAlerte(Request $request)
{
    // ✅ Validation des données
    $validated = $request->validate([
        'id_utilisateur' => 'required|integer|exists:utilisateurs,id',
        'description' => 'required|string',
        'typeAlerte' => 'required|string',
        'destinataire' => 'required|string',
        'email' => 'required|email'
    ]);

    // 📝 Création de l'alerte dans la base de données
    $alerte = Alerte::create([
        'id_utilisateur' => $validated['id_utilisateur'],
        'description' => $validated['description'],
        'typeAlerte' => $validated['typeAlerte'],
        'destinataire' => $validated['destinataire'],
    ]);

    // ✉️ Construction du message
    $contenu = "Nouvelle alerte du système :\n\n" .
               "Utilisateur ID : {$validated['id_utilisateur']}\n" .
               "Type : {$validated['typeAlerte']}\n" .
               "Description : {$validated['description']}\n" .
               "Destinataire : {$validated['destinataire']}";

    // 📧 Envoi du mail sans vue Blade
    Mail::raw($contenu, function ($message) use ($validated) {
        $message->to($validated['email'])
                ->subject('Alerte Système');
    });

    return response()->json([
        'message' => 'Alerte enregistrée et email envoyé avec succès',
        'alerte' => $alerte
    ], 201);
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
