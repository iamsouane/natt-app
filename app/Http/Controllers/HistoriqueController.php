<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotisation;
use App\Models\Tontine;
use Illuminate\Support\Facades\Auth;

class HistoriqueController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Récupère toutes les cotisations du participant connecté avec la relation tontine
    $cotisations = Cotisation::with('tontine')
        ->where('id_user', $user->id)
        ->orderBy('date_cotisation', 'desc')
        ->get();

    // Nombre unique de tontines auxquelles l'utilisateur a cotisé
    $tontinesParticipees = $cotisations->pluck('id_tontine')->unique()->count();

    // Montant total cotisé (la somme brute dans la table cotisations)
    $totalCotise = $cotisations->sum('montant');

    // Calcul du montant partiel par tontine selon la méthode de CotisationController (arrondi à l'excès)
    $montantsPartiels = [];
    foreach ($cotisations->pluck('tontine')->unique('id') as $tontine) {
        if ($tontine->nbre_cotisation > 0) {
            $montantsPartiels[$tontine->id] = ceil(floatval($tontine->montant_de_base) / $tontine->nbre_cotisation);
        } else {
            $montantsPartiels[$tontine->id] = 0;
        }
    }

    return view('participant.historique.index', [
        'cotisations' => $cotisations,
        'tontinesParticipees' => $tontinesParticipees,
        'totalCotise' => $totalCotise,
        'montantsPartiels' => $montantsPartiels,
    ]);
}


}