<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TontineController;
use App\Http\Controllers\TirageController;
use App\Http\Controllers\CotisationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page d'accueil
Route::get('/', [InscriptionController::class, 'home'])->name('home');

// Inscription
Route::get('register.html', [InscriptionController::class, 'index'])->name('inscription.index');
Route::post('validate-register', [InscriptionController::class, 'register'])->name('inscription.register');

// Connexion
Route::get('login.html', [AuthController::class, 'create'])->name('auth.create');
Route::post('connexion', [AuthController::class, 'auth'])->name('auth.store');

// Déconnexion
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Routes pour SUPER_ADMIN et GERANT
Route::middleware(['auth', 'role:SUPER_ADMIN,GERANT'])->prefix('admin')->group(function () {
    Route::resource('tontines', TontineController::class);
    Route::resource('tirages', TirageController::class);  // Ajout des routes pour les tirages
});

// Routes pour les participants
Route::middleware(['auth', 'role:PARTICIPANT'])->prefix('participant')->group(function () {
    Route::get('tontines', [TontineController::class, 'index'])->name('participant.tontines.index');
    Route::get('tontines/{tontine}', [CotisationController::class, 'show'])->name('participant.tontines.show');
    Route::get('cotisations/{tontine}/create', [CotisationController::class, 'create'])->name('participant.cotisations.create');
    Route::post('cotisations/{tontine}', [CotisationController::class, 'store'])->name('participant.cotisations.store');
});