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
        // Vérification si le participant peut cotiser à cette séance
        if (!$tontine->canCotiser()) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "La séance actuelle n'est pas encore terminée. Vous ne pouvez pas cotiser.");
        }

        $nbreCotisations = Cotisation::where('id_user', Auth::id())
            ->where('id_tontine', $tontine->id)
            ->count();

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
        // Vérification si le participant peut cotiser à cette séance
        if (!$tontine->canCotiser()) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "La séance actuelle n'est pas encore terminée. Vous ne pouvez pas cotiser.");
        }

        $nbreCotisations = Cotisation::where('id_user', Auth::id())
            ->where('id_tontine', $tontine->id)
            ->count();

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
            'id_user' => Auth::id(),
            'id_tontine' => $tontine->id,
            'montant' => $montant_partiel,
            'moyen_paiement' => $request->moyen_paiement,
            'date_cotisation' => Carbon::now(),
        ]);

        return redirect()->route('participant.cotisations.index')
            ->with('success', "Cotisation enregistrée !");
    }
}