<<<<<<< HEAD
<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\ReservationPavillonController;
use App\Http\Controllers\ReservationCantineController;
use App\Http\Controllers\PaiementController;
use App\Models\Affectation;
use App\Models\Alerte;
use App\Models\Reclamation;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Réclamation
Route::post('/reclamations', [ReclamationController::class, 'store']);
Route::put('/reclamations/{id}', [ReclamationController::class, 'update']);
Route::get('/reclamations', [ReclamationController::class, 'index']);
Route::get('/reclamations/{id}', [ReclamationController::class, 'show']);
Route::delete('/reclamations/{id}', [ReclamationController::class, 'destroy']);



// Alerte
Route::post('/alertes', [AlerteController::class, 'envoyerAlerte']);
Route::get('/alertes', [AlerteController::class, 'afficherAlerte']);
Route::get('/alertes/{id}', [AlerteController::class, 'show']);
Route::put('/alertes/{id}', [AlerteController::class, 'update']);
Route::delete('/alertes/{id}', [AlerteController::class, 'destroy']);




// Rapport
Route::post('/rapports', [RapportController::class, 'creerRapport']);
Route::get('/rapports', [RapportController::class, 'index']);
Route::get('/rapports/{id}', [RapportController::class, 'afficherRaport']);
Route::put('/rapports/{id}', [RapportController::class, 'modifierRapport']);
Route::delete('/rapports/{id}', [RapportController::class, 'supprimerRapport']);

// Contrat
Route::post('/contrats', [ContratController::class, 'creerContrat']);
Route::get('/contrats', [ContratController::class, 'index']);
Route::get('/contrats/{id}', [ContratController::class, 'afficherContrat']);
Route::put('/contrats/{id}', [ContratController::class, 'modifiercontrat']);
Route::delete('/contrats/{id}', [ContratController::class, 'supprimerContrat']);

// Affectation
Route::post('/affectations', [AffectationController::class, 'creerAffectation']);
Route::get('/affectations/{id}', [AffectationController::class, 'afficherAffectation']);
Route::put('/affectations/{id}', [AffectationController::class, 'modifierAffectation']);
Route::delete('/affectations/{id}', [AffectationController::class, 'supprimerAffectation']);



// Réservation Pavillon
Route::post('/reservation/pavillons', [ReservationPavillonController::class, 'faireReservation']);
Route::get('/reservation/pavillons', [ReservationPavillonController::class, 'index']);
Route::get('/reservation/pavillons/{id}', [ReservationPavillonController::class, 'afficherReservation']);
Route::put('/reservation/pavillons/{id}', [ReservationPavillonController::class, 'modifierreservation']);
Route::delete('/reservation/pavillons/{id}', [ReservationPavillonController::class, 'supprimerReservation']);

// Réservation Cantine
Route::post('/reservations/cantine', [ReservationCantineController::class, 'faireReservation']);
Route::get('/reservations/cantine/{id}', [ReservationCantineController::class, 'afficherReservation']);
Route::get('/reservations/cantine', [ReservationCantineController::class, 'index']);
Route::put('/reservations/cantine/{id}', [ReservationCantineController::class, 'modifierreservation']);
Route::delete('/reservations/cantine/{id}', [ReservationCantineController::class, 'supprimerReservation']);

// Paiement
Route::middleware('auth:sanctum')->post('/paiement', [PaiementController::class, 'fairePaiement']);

Route::post('/paiements', [PaiementController::class, 'fairePaiement']);
Route::get('/paiements', [PaiementController::class, 'afficherPaiement']);
Route::put('/paiements/{id}', [PaiementController::class, 'modifierPaiement']);
Route::delete('/paiements/{id}', [PaiementController::class, 'supprimerPaiement']);
=======

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\TechnicienController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\GestionnaireController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes publiques (non authentifiées)
Route::prefix('v1')->group(function () {
    // Authentification routes
    Route::post('/login', [UtilisateurController::class, 'login']);
    Route::post('/register', [UtilisateurController::class, 'register']);
    
    // Password modifier
    Route::post('/demandeChangementPwd', [UtilisateurController::class, 'demandeChangementPwd']);
    Route::post('/reinitialisePwd', [UtilisateurController::class, 'reinitialisePwd']);
    
});
>>>>>>> c530ec14f7a88e7e7107b305514ce64b621c72fc
