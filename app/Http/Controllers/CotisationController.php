<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotisation;
use App\Models\Tontine;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CotisationController extends Controller
{
    public function index()
    {
        $tontines = Tontine::all();
        return view('participant.cotisations.index', compact('tontines'));
    }

    public function create(Tontine $tontine)
    {
        $userId = Auth::id();
        $seanceActuelle = $tontine->getSeanceActuelle();

        $aCotise = Cotisation::where('id_tontine', $tontine->id)
                             ->where('id_user', $userId)
                             ->exists();

        $participantsActuels = Cotisation::where('id_tontine', $tontine->id)
                                         ->distinct('id_user')->count('id_user');

        if (!$aCotise && $participantsActuels >= $tontine->nbre_participant) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Le nombre maximum de participants est atteint.");
        }

        // Vérifie si l'utilisateur a déjà cotisé pour la séance actuelle
        $aCotisePourSeanceActuelle = Cotisation::where('id_tontine', $tontine->id)
            ->where('id_user', $userId)
            ->where('numero_seance', $seanceActuelle)
            ->exists();

        if ($aCotisePourSeanceActuelle) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous avez déjà cotisé pour la séance $seanceActuelle.");
        }

        // Calcul du montant partiel et arrondi à l'excès
        $montant_partiel = $tontine->nbre_cotisation > 0 
            ? ceil(floatval($tontine->montant_de_base) / $tontine->nbre_cotisation)  // Conversion en float avant d'arrondir
            : 0;

        return view('participant.cotisations.create', compact('tontine', 'montant_partiel', 'seanceActuelle'));
    }

    public function store(Request $request, Tontine $tontine)
    {
        $userId = Auth::id();
        $seanceActuelle = $tontine->getSeanceActuelle();

        $aCotise = Cotisation::where('id_tontine', $tontine->id)
                             ->where('id_user', $userId)
                             ->exists();

        $participantsActuels = Cotisation::where('id_tontine', $tontine->id)
                                         ->distinct('id_user')->count('id_user');

        if (!$aCotise && $participantsActuels >= $tontine->nbre_participant) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Le nombre maximum de participants est atteint.");
        }

        $aCotisePourSeanceActuelle = Cotisation::where('id_tontine', $tontine->id)
            ->where('id_user', $userId)
            ->where('numero_seance', $seanceActuelle)
            ->exists();

        if ($aCotisePourSeanceActuelle) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous avez déjà cotisé pour la séance $seanceActuelle. Il faut attendre la prochaine séance.");
        }

        if ($seanceActuelle > $tontine->nbre_cotisation) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Toutes les séances de cotisation sont terminées.");
        }

        // Enregistrement de la cotisation avec arrondi
        Cotisation::create([
            'id_user' => $request->user()->id,
            'id_tontine' => $tontine->id,
            'montant' => ceil(floatval($request->montant)),  // Conversion en float avant d'arrondir
            'moyen_paiement' => $request->moyen_paiement,
            'date_cotisation' => now(),
            'numero_seance' => $seanceActuelle,
        ]);

        return redirect()->route('participant.cotisations.index')
            ->with('success', "Cotisation enregistrée pour la séance $seanceActuelle.");
    }
}