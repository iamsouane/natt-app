<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;


class CotisationController extends Controller
{
    // Afficher la liste des tontines disponibles
    public function index()
    {
        $tontines = Tontine::where('date_fin', '>', now())->get(); // Tontines actives
        return view('participant.tontines.index', compact('tontines'));
    }

    // Afficher les détails d'une tontine
    public function show(Tontine $tontine)
    {
        return view('participant.tontines.show', compact('tontine'));
    }

    // Afficher le formulaire de cotisation
    public function create(Tontine $tontine)
    {
        return view('participant.cotisations.create', compact('tontine'));
    }

    // Enregistrer la cotisation
    public function store(Request $request, Tontine $tontine)
    {
        $request->validate([
            'montant' => 'required|numeric',
            'moyen_paiement' => 'required|in:ESPECES,WAVE,OM',
        ]);

        // Enregistrer la cotisation
        Cotisation::create([
            'id_user' => Auth::id(),
            'id_tontine' => $tontine->id,
            'montant' => $request->montant,
            'moyen_paiement' => $request->moyen_paiement,
            'statut_paiement' => 'PAYE', // Ou 'NON_PAYE' selon votre logique
        ]);

        return redirect()->route('participant.tontines.index')->with('success', 'Cotisation enregistrée avec succès.');
    }
}
