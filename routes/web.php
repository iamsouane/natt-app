<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TontineController;
use App\Http\Controllers\TirageController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\NotificationController;

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
    Route::resource('tirages', TirageController::class);
    Route::get('tirages', [TirageController::class, 'index'])->name('tirages.index');
    
    // Route pour effectuer un tirage d'une séance donnée
    Route::get('tirages/{tontine}/{seance}/effectuer', [TirageController::class, 'effectuerTirage'])
        ->name('tirages.effectuer');
    
    Route::post('tontines/sendEmails', [TontineController::class, 'sendEmails'])->name('tontines.sendEmails');
});

// Routes pour les participants
Route::middleware(['auth', 'role:PARTICIPANT'])->prefix('participant')->group(function () {
    Route::get('cotisations/{tontine}/create', [CotisationController::class, 'create'])->name('participant.cotisations.create');
    Route::post('cotisations/{tontine}', [CotisationController::class, 'store'])->name('participant.cotisations.store');
    Route::get('cotisations', [CotisationController::class, 'index'])->name('participant.cotisations.index');
    Route::get('/cotisations/{cotisation}', [CotisationController::class, 'show'])->name('participant.cotisations.show');
});