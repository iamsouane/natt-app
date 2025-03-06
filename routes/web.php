<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TontineController;


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
Route::middleware(['auth', 'role:SUPER_ADMIN,GERANT'])->group(function () {
    // Gestion des tontines
    Route::resource('tontines', TontineController::class);

    // Gestion des tirages
    Route::resource('tirages', TirageController::class);
});