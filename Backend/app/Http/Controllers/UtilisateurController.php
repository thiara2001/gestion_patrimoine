<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

abstract class UtilisateurController extends Controller
{
    /**
     * Inscription.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateurs',
            'password' => 'required|string|min:8|confirmed',
            'sexe' => 'required|in:F,H',
            'age' => 'required|integer',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'type' => 'required|string|max:255',
            'role' => 'required|in:Gestionnaire,Technicien,AgentQHSE,Commercant,Etudiant'
        ]);

        $utlisateurClass = 'App\\Models\\'.$request->role;
        if (!class_exists($utlisateurClass)){
            return response()->json(['message' => 'Ce type d\'utilisateur n\'existe'], 400);
        }

        $utilisateur = $utlisateurClass::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sexe' => $request->sexe,
            'age' => $request->age,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'type' => $request->type,
            'role' => $request->role,
        ]);

        $token = $utilisateur->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Inscription validee',
            'utilissateur' => $utilisateur,
            'token' => $token,
        ], 201);
    }

    /**
     * Connexion.
     */
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($request->only('email', 'password'))){
            throw ValidationException::withMessages([
                'email' => ['Email ou mot de passe incorrect'],
            ]);
        }

        $utilisateur = Utilisateur::where('email', $request->email)->firstOrFail();
        $token = $utilisateur->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion reussie',
            'utilisateur' =>$utilisateur,
            'token' => $token
        ]);
        
    }

    /**
     * Deconnexion.
     */
    public function logout(Request $request)
    {
       $request->user()->currentAccessToken()->delete();

       return response()->json([
        'message' => 'Deconnexio reussi',
        'success' => 'true'
       ]);
        
    }

    /**
     * Permet de recuperer les informations l'utilisateur et les afficher.
     */
    public function utilisateur(Request $request)
    {
        $utilisateur = Auth::user();

        return response()->json([
            'utilisateur' => $utilisateur,
            'type' => $utilisateur->getUserType(),
            'success' => true
        ]);
    }

    /**
     * Permet a l'utilisateur de modifier ses informations 
     */
    public function modifierUtilisateur(Request $request){

        $utilisateur = Auth::user();

       $data = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:utilisateurs',
            'sexe' => 'sometimes|in:F,H',
            'age' => 'sometimes|integer',
            'adresse' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20',
            'type' => 'sometimes|string|max:255',
            'role' => 'sometimes|in:Gestionnaire,Technicien,AgentQHSE,Commercant,Etudiant'
        ]);

        $utilisateur->update($data);

        return response()->json([
            'message' => 'Information modifier avec succes',
            'utilisateur' => $utilisateur,
            'success' => true
        ]);
    }

    /**
     * Changer de mot de passe
     */

    public function modifierPwd(Request $request){
        
        $utilisateur = Auth::user();

        $data = $request->validate([
            'ancienPwd' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if(!Hash::check($data['ancienPwd'], $utilisateur->password)){
            return response()->json([
                'message' => 'Mot de passe incorrect',
                'success' => false
            ], 400);
        }

        $utilisateur->password = Hash::make($data['password']);
        $utilisateur->save();

        return response()->json([
            'message' => 'Mot de passe changer',
            'success' => true
        ]);
    }

    /**
     * ces deux fonction permet à l'utlisateur de changer de passe en cas d'oubli
     */
    public function demandeChangementPwd(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $utilisateur = Utilisateur::where('email', $data['email'])->first();

        if(!$utilisateur){
            return response()->json([
                'message'=>'Verifier votre mot de passe',
                'success'=>false
            ], 404);
        }

        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $data['email']],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Envoyer l'email avec le lien de réinitialisation
        // (L'URL devrait pointer vers votre page frontend de réinitialisation)
        $resetUrl = url('/reset-password') . '?email=' . $data['email'] . '&token=' . $token;

        return response()->json([
            'message' => 'Veuillez verifier votre email un lien va vous etre envoyer',
            'success' => true
        ]);

    }

    public function reinitialisePwd(Request $request)  {
        
        $data = $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        //verifier si le token n'a pas expirer
        $expireToken = DB::table('password_reset_tokens')->where('email', $data['email'])->first();
         
        if (!$expireToken || !Hash::check($data['token'], $expireToken->token) || Carbon::parse($expireToken->created_at)->addHours(24)->isPast()) {
            
            return response()->json([
            'message' => 'Ce lien de réinitialisation est invalide ou a expiré',
            'success' => false
            ], 400);
        }

        $utilisateur = Utilisateur::where('email', $data['email'])->first();
        $utilisateur->password = Hash::make($data['password']);
        $utilisateur->save();

        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        return response()->json([
            'message' => 'Mot de passe reinitialise',
            'success' => true
        ]);
    }

}
