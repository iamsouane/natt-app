<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotisation;
use App\Models\Tontine;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CotisationController extends Controller
{
    /**
     * Affiche la liste des tontines disponibles.
     */
    public function index()
    {
        $tontines = Tontine::all();
        return view('participant.cotisations.index', compact('tontines'));
    }

    /**
     * Affiche le formulaire de cotisation pour une tontine spécifique.
     */
    public function create(Tontine $tontine)
    {
        $userId = Auth::id();

        $nbreCotisations = Cotisation::where('id_user', $userId)
            ->where('id_tontine', $tontine->id)
            ->count();

        $participantsActuels = Cotisation::where('id_tontine', $tontine->id)
            ->distinct('id_user')
            ->count('id_user');

        // Empêche un nouveau participant de cotiser si la première séance est terminée
        if ($nbreCotisations === 0 && !$tontine->canCotiser()) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous ne pouvez plus rejoindre cette tontine. La première séance est terminée.");
        }

        // Empêche un nouveau participant de cotiser si le nombre max de participants est atteint
        if ($nbreCotisations === 0 && $participantsActuels >= $tontine->nbre_participant) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous ne pouvez plus rejoindre cette tontine. Le nombre maximum de participants est atteint.");
        }

        if ($nbreCotisations >= $tontine->nbre_cotisation) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Cotisations maximales atteintes.");
        }

        $montant_partiel = $tontine->nbre_cotisation > 0 
            ? $tontine->montant_de_base / $tontine->nbre_cotisation 
            : 0;

        return view('participant.cotisations.create', compact('tontine', 'montant_partiel'));
    }

    /**
     * Enregistre une cotisation.
     */
    public function store(Request $request, Tontine $tontine)
    {
        $userId = Auth::id();

        $nbreCotisations = Cotisation::where('id_user', $userId)
            ->where('id_tontine', $tontine->id)
            ->count();

        $participantsActuels = Cotisation::where('id_tontine', $tontine->id)
            ->distinct('id_user')
            ->count('id_user');

        // Empêche un nouveau participant de cotiser après la première séance
        if ($nbreCotisations === 0 && !$tontine->canCotiser()) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous ne pouvez plus cotiser. La première séance est terminée.");
        }

        // Empêche un nouveau participant de cotiser si le nombre max est atteint
        if ($nbreCotisations === 0 && $participantsActuels >= $tontine->nbre_participant) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous ne pouvez plus cotiser. Le nombre maximum de participants est atteint.");
        }

        if ($nbreCotisations >= $tontine->nbre_cotisation) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Cotisations maximales atteintes.");
        }

        $montant_partiel = $tontine->nbre_cotisation > 0 
            ? $tontine->montant_de_base / $tontine->nbre_cotisation 
            : 0;

        if ($montant_partiel <= 0) {
            return redirect()->back()->with('error', "Montant invalide.");
        }

        Cotisation::create([
            'id_user' => $userId,
            'id_tontine' => $tontine->id,
            'montant' => $montant_partiel,
            'moyen_paiement' => $request->moyen_paiement,
            'date_cotisation' => Carbon::now(),
        ]);

        return redirect()->route('participant.cotisations.index')
            ->with('success', "Cotisation enregistrée !");
    }
}