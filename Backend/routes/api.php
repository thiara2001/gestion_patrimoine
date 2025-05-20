
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\API\TechnicienController;
use App\Http\Controllers\API\EquipementController;
use App\Http\Controllers\API\AlerteController;
use App\Http\Controllers\API\ContratController;
use App\Http\Controllers\API\GestionnaireController;

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
