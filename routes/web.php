<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TontineController;
use App\Http\Controllers\TirageController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\ContactController;

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

// Réinitialisation du mot de passe (sans email)
Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
Route::post('forgot-password', [AuthController::class, 'verifyEmail'])->name('password.verifyEmail');
Route::get('reset-password/{email}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Routes pour SUPER_ADMIN et GERANT
Route::middleware(['auth', 'role:SUPER_ADMIN,GERANT'])->prefix('admin')->group(function () {
    Route::resource('tontines', TontineController::class);
    Route::resource('tirages', TirageController::class);
    Route::get('tirages', [TirageController::class, 'index'])->name('tirages.index');

    // Route pour effectuer un tirage d'une séance donnée
    Route::get('tirages/{tontine}/{seance}/effectuer', [TirageController::class, 'effectuerTirage'])
        ->name('tirages.effectuer');

    Route::post('tontines/sendEmails', [TontineController::class, 'sendEmails'])->name('tontines.sendEmails');

    Route::post('tontines/{tontine}/promouvoir', [TontineController::class, 'promouvoirGerant'])->name('tontines.promouvoir');
});

// Routes pour les participants
Route::middleware(['auth', 'role:PARTICIPANT'])->prefix('participant')->group(function () {
    Route::get('cotisations/{tontine}/create', [CotisationController::class, 'create'])->name('participant.cotisations.create');
    Route::post('cotisations/{tontine}', [CotisationController::class, 'store'])->name('participant.cotisations.store');
    Route::get('tontines', [TontineController::class, 'voirPourParticipant'])->name('participant.index');
    Route::get('cotisations', [CotisationController::class, 'index'])->name('participant.cotisations.index');
    Route::get('/cotisations/{cotisation}', [CotisationController::class, 'show'])->name('participant.cotisations.show');

    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('participant.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('participant.profile.update');

    Route::get('/participant/historique', [\App\Http\Controllers\HistoriqueController::class, 'index'])->name('participant.historique');

    Route::post('tontines/{tontine}/send-mails-gerant', [TontineController::class, 'sendMailsGerant'])
    ->name('participant.tontines.sendMailsGerant');

});

// Pages statiques
Route::get('/about', [StaticPageController::class, 'about'])->name('about');
Route::get('/contact', [StaticPageController::class, 'contact'])->name('contact');
Route::get('/politique', [StaticPageController::class, 'politique'])->name('politique');

// Reclamation
Route::middleware('auth')->group(function () {
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
});