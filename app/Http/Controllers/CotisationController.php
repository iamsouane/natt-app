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
        $seanceActuelle = $this->calculerSeanceActuelle($tontine);

        $aCotise = Cotisation::where('id_tontine', $tontine->id)
                             ->where('id_user', $userId)
                             ->exists();

        $participantsActuels = Cotisation::where('id_tontine', $tontine->id)
                                         ->distinct('id_user')->count('id_user');

        if ($participantsActuels >= $tontine->nbre_participant && !$aCotise) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Le nombre maximum de participants est atteint.");
        }

        $aCotisePourSeanceActuelle = Cotisation::where('id_tontine', $tontine->id)
            ->where('id_user', $userId)
            ->where('numero_seance', $seanceActuelle)
            ->exists();

        if ($aCotisePourSeanceActuelle) {
            return redirect()->route('participant.cotisations.index')
                ->with('error', "Vous avez déjà cotisé pour la séance $seanceActuelle.");
        }

        $montant_partiel = $tontine->nbre_cotisation > 0 
            ? $tontine->montant_de_base / $tontine->nbre_cotisation 
            : 0;

        return view('participant.cotisations.create', compact('tontine', 'montant_partiel', 'seanceActuelle'));
    }

    public function store(Request $request, Tontine $tontine)
    {
        $userId = Auth::id();
        $seanceActuelle = $this->calculerSeanceActuelle($tontine);

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
                ->with('error', "Le nombre maximal de séances est atteint.");
        }

        $montant_partiel = $tontine->nbre_cotisation > 0 
            ? $tontine->montant_de_base / $tontine->nbre_cotisation 
            : 0;

        Cotisation::create([
            'id_user' => $userId,
            'id_tontine' => $tontine->id,
            'montant' => $montant_partiel,
            'moyen_paiement' => $request->moyen_paiement,
            'date_cotisation' => Carbon::now(),
            'numero_seance' => $seanceActuelle,
        ]);

        return redirect()->route('participant.cotisations.index')
            ->with('success', "Cotisation enregistrée pour la séance $seanceActuelle !");
    }

    /**
     * Calcule la séance actuelle en respectant la contrainte du jour suivant
     */
    private function calculerSeanceActuelle(Tontine $tontine): int
    {
        $nbParticipants = $tontine->nbre_participant;

        $cotisations = Cotisation::where('id_tontine', $tontine->id)
            ->orderBy('numero_seance')
            ->get()
            ->groupBy('numero_seance');

        if ($cotisations->isEmpty()) {
            return 1;
        }

        $derniereSeance = $cotisations->keys()->last();
        $cotisationsDerniereSeance = $cotisations[$derniereSeance];

        if ($cotisationsDerniereSeance->count() < $nbParticipants) {
            return $derniereSeance;
        }

        $derniereDateCotisation = $cotisationsDerniereSeance->max('date_cotisation');
        $dateDerniereCotisation = Carbon::parse($derniereDateCotisation);

        if ($dateDerniereCotisation->isToday()) {
            return $derniereSeance;
        }

        return $derniereSeance + 1;
    }
}