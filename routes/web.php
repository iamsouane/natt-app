<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TontineController;
use App\Http\Controllers\TirageController;
use App\Http\Controllers\CotisationController;
use App\Mail\RappelCotisation;
use App\Models\User;
use App\Models\Tontine;
use App\Models\Cotisation;

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
    Route::post('tontines/sendEmails', [TontineController::class, 'sendEmails'])->name('tontines.sendEmails');

});

// Routes pour les participants
Route::middleware(['auth', 'role:PARTICIPANT'])->prefix('participant')->group(function () {
    Route::get('cotisations/{tontine}/create', [CotisationController::class, 'create'])->name('participant.cotisations.create');
    Route::post('cotisations/{tontine}', [CotisationController::class, 'store'])->name('participant.cotisations.store');
    Route::get('cotisations', [CotisationController::class, 'index'])->name('participant.cotisations.index');
    Route::get('/cotisations/{cotisation}', [CotisationController::class, 'show'])->name('participant.cotisations.show');
});

Route::get('/test-email', function () {
    // Récupérer tous les participants
    $participants = User::where('profil', 'PARTICIPANT')->get();

    // Vérifier s'il y a des participants
    if ($participants->isEmpty()) {
        return "Aucun participant trouvé.";
    }

    // Récupérer toutes les tontines
    $tontines = Tontine::all();

    // Vérifier si les tontines existent
    if ($tontines->isEmpty()) {
        return "Aucune tontine trouvée.";
    }

    // Parcourir chaque participant
    foreach ($participants as $participant) {
        // Parcourir chaque tontine à laquelle le participant peut être inscrit
        foreach ($tontines as $tontine) {
            // Vérifier si ce participant a une cotisation pour cette tontine
            $cotisation = Cotisation::where('id_user', $participant->id)
                                    ->where('id_tontine', $tontine->id)
                                    ->first();

            // Si aucune cotisation ou cotisation en retard
            if (!$cotisation || $cotisation->seanceEnRetard()) {
                // Envoi du mail de rappel si la cotisation est en retard
                Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'rappel'));
            } else {
                // Envoi du mail de confirmation si la cotisation est enregistrée
                Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'confirmation'));
            }
        }
    }

    return "Emails envoyés à tous les participants pour toutes les tontines.";
});