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
     * Afficher la liste des tontines disponibles pour un participant.
     */
    public function index()
    {
        // Récupérer toutes les tontines disponibles
        $tontines = Tontine::all();
        return view('participant.cotisations.index', compact('tontines'));
    }

    /**
     * Afficher le formulaire de cotisation pour une tontine spécifique.
     */
    public function create(Tontine $tontine)
    {
        // Vérifier le nombre de cotisations déjà effectuées par l'utilisateur
        $nbreCotisations = Cotisation::where('id_user', Auth::id())
            ->where('id_tontine', $tontine->id)
            ->count();

        if ($nbreCotisations >= $tontine->nbre_cotisation) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous avez atteint le nombre de cotisations maximum pour cette tontine.");
        }

        // Calcul du montant à cotiser par séance
        $montant_partiel = ($tontine->nbre_cotisation > 0) 
            ? $tontine->montant_de_base / $tontine->nbre_cotisation 
            : 0;

        return view('participant.cotisations.create', compact('tontine', 'montant_partiel'));
    }

    /**
     * Enregistrer une nouvelle cotisation.
     */
    public function store(Request $request, Tontine $tontine)
    {
        // Vérifier si le participant a déjà atteint le nombre de cotisations
        $nbreCotisations = Cotisation::where('id_user', Auth::id())
            ->where('id_tontine', $tontine->id)
            ->count();

        if ($nbreCotisations >= $tontine->nbre_cotisation) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous avez atteint le nombre de cotisations maximum pour cette tontine.");
        }

        // Calcul automatique du montant de cotisation
        $montant_partiel = ($tontine->nbre_cotisation > 0) 
            ? $tontine->montant_de_base / $tontine->nbre_cotisation 
            : 0;

        // Vérification si le montant est valide
        if ($montant_partiel <= 0) {
            return redirect()->back()->with('error', "Erreur dans le calcul du montant.");
        }

        // Enregistrement de la cotisation
        Cotisation::create([
            'id_user' => Auth::id(),
            'id_tontine' => $tontine->id,
            'montant' => $montant_partiel,
            'moyen_paiement' => $request->moyen_paiement,
            'date_cotisation' => Carbon::now(),
        ]);

        return redirect()->route('participant.cotisations.index')
            ->with('success', "Cotisation enregistrée avec succès !");
    }
}