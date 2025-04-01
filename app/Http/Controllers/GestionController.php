<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;
use App\Models\Cotisation;

class GestionController extends Controller
{
    // Afficher les détails d'une tontine avec les séances cotisées et restantes
    public function show()
    {
        // Récupérer toutes les tontines avec leurs participants et utilisateurs associés
        $tontines = Tontine::with('participants.user')->get();

        // Préparer les données avec les séances cotisées/restantes
        $tontinesData = $tontines->map(function ($tontine) {
            // Récupération des participants uniques
            $participants = $tontine->participants->unique('id_user')->map(function ($participant) use ($tontine) {
                $cotisationsEffectuees = Cotisation::where('id_user', $participant->id_user)
                    ->where('id_tontine', $tontine->id)
                    ->count();

                return [
                    'nom' => $participant->user->prenom . ' ' . $participant->user->nom,
                    'email' => $participant->user->email,
                    'cotisations_effectuees' => $cotisationsEffectuees,
                    'seances_restantes' => max(0, $tontine->nbre_cotisation - $cotisationsEffectuees)
                ];
            });

            return [
                'tontine' => $tontine->libelle,
                'nbre_seances' => $tontine->nbre_cotisation,
                'participants' => $participants
            ];
        });

        return view('gestion.show', compact('tontinesData'));
    }
}
