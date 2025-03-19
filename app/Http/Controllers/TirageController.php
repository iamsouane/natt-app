<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;
use App\Models\Tirage;
use App\Models\User;
use App\Models\Cotisation;

class TirageController extends Controller
{
    public function index(Request $request)
    {
        // Récupère les tontines avec cotisations disponibles
        $tontines = Tontine::where('nbre_cotisation', '>', 0)->get();

        // Récupère les tirages existants
        $tirages = Tirage::with(['user', 'tontine'])
            ->when($request->tontine_id, function ($query) use ($request) {
                $query->where('id_tontine', $request->tontine_id);
            })
            ->latest()
            ->get();

        return view('tirages.index', compact('tontines', 'tirages'));
    }

    public function effectuerTirage(Request $request)
    {
        $tontine = Tontine::findOrFail($request->tontine);
        $seance = $request->input('seance'); // Séance sélectionnée
        $nbParticipants = $tontine->nbre_participant;

        // Vérifie que la séance demandée est valide et ne dépasse pas le nombre de cotisations
        if ($seance > $tontine->nbre_cotisation) {
            return back()->with('error', "Le nombre maximal de séances est atteint.");
        }

        // Compte le nombre total de cotisations effectuées
        $totalCotisations = Cotisation::where('id_tontine', $tontine->id)->count();

        // Calcul de la séance actuelle en fonction du nombre total de cotisations
        $seanceActuelle = ceil($totalCotisations / $nbParticipants);

        // Vérifie que la séance demandée est bien la séance actuelle
        if ($seance != $seanceActuelle) {
            return back()->with('error', "Impossible de faire le tirage pour la séance $seance. La séance actuelle est la séance $seanceActuelle.");
        }

        // Vérifie que tous les participants ont cotisé pour cette séance
        $cotisationsSeance = Cotisation::where('id_tontine', $tontine->id)
            ->whereRaw('FLOOR((DATEDIFF(date_cotisation, ?) / ?) + 1) = ?', [$tontine->date_debut, 1, $seance])
            ->pluck('id_user');

        if ($cotisationsSeance->count() < $nbParticipants) {
            return back()->with('error', "Tous les participants n'ont pas encore cotisé pour la séance $seance.");
        }

        // Vérifie s'il existe déjà un tirage pour cette séance
        $tirageExist = Tirage::where('id_tontine', $tontine->id)
                            ->where('numero_seance', $seance)
                            ->exists();

        // Si un tirage existe déjà pour cette séance, ne permet pas un nouveau tirage
        if ($tirageExist) {
            return back()->with('error', "Le tirage pour la séance $seance a déjà été effectué.");
        }

        // Exclut les gagnants précédents pour cette tontine et cette séance
        $participantsEligibles = User::whereHas('cotisations', function ($query) use ($tontine) {
                $query->where('id_tontine', $tontine->id);
            })
            ->whereDoesntHave('tirages', function ($query) use ($tontine, $seance) {
                $query->where('id_tontine', $tontine->id)
                    ->where('numero_seance', '<', $seance); // Exclut les gagnants des séances précédentes
            })
            ->get();

        // Si aucun participant éligible, retourne une erreur
        if ($participantsEligibles->isEmpty()) {
            return back()->with('error', "Plus aucun participant éligible pour cette tontine. Tous ont déjà gagné.");
        }

        // Tirage pour un seul gagnant
        $gagnant = $participantsEligibles->random();

        // Enregistrement du tirage dans la base de données
        Tirage::create([
            'id_user' => $gagnant->id,
            'id_tontine' => $tontine->id,
            'numero_seance' => $seance,  // Assure que seul ce gagnant soit lié à cette séance
        ]);

        // Exclure ce gagnant des séances suivantes en utilisant la condition 'whereDoesntHave' pour le tirage
        return redirect()->route('tirages.index')->with('gagnant', $gagnant->prenom . ' ' . $gagnant->nom);
    }
}