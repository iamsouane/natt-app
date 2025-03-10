<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;
use Carbon\Carbon;

class TontineController extends Controller
{
    // Afficher la liste des tontines
    public function index()
    {
        $tontines = Tontine::all();
        return view('tontines.index', compact('tontines'));
    }

    // Afficher le formulaire de création d'une tontine
    public function create()
    {
        return view('tontines.create');
    }

    // Enregistrer une nouvelle tontine
    public function store(Request $request)
    {
        $request->validate([
            'frequence' => 'required|in:JOURNALIERE,HEBDOMADAIRE,MENSUELLE',
            'libelle' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'description' => 'required',
            'montant_total' => 'required|numeric|min:1',
            'montant_de_base' => 'required|numeric|min:1',
            'nbre_participant' => 'required|integer|min:1',
        ]);

        // Calcul de la durée en jours
        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);
        $duree = $dateDebut->diffInDays($dateFin);

        // Vérifier la fréquence en fonction de la durée
        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return redirect()->back()->withErrors(['frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIERE ou HEBDOMADAIRE."])->withInput();
        }

        // Calcul du nombre de cotisations
        $nbreCotisation = intval($request->montant_total / $request->montant_de_base);

        // Création de la tontine avec le calcul automatique de nbre_cotisation
        Tontine::create([
            'frequence' => $request->frequence,
            'libelle' => $request->libelle,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'description' => $request->description,
            'montant_total' => $request->montant_total,
            'montant_de_base' => $request->montant_de_base,
            'nbre_participant' => $request->nbre_participant,
            'nbre_cotisation' => $nbreCotisation,
        ]);

        return redirect()->route('tontines.index')->with('success', 'Tontine créée avec succès.');
    }

    // Afficher les détails d'une tontine
    public function show(Tontine $tontine)
    {
        return view('tontines.show', compact('tontine'));
    }

    // Afficher le formulaire de modification d'une tontine
    public function edit(Tontine $tontine)
    {
        return view('tontines.edit', compact('tontine'));
    }

    // Mettre à jour une tontine
    public function update(Request $request, Tontine $tontine)
    {
        $request->validate([
            'frequence' => 'required|in:JOURNALIERE,HEBDOMADAIRE,MENSUELLE',
            'libelle' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'description' => 'required',
            'montant_total' => 'required|numeric|min:1',
            'montant_de_base' => 'required|numeric|min:1',
            'nbre_participant' => 'required|integer|min:1',
        ]);

        // Calcul de la durée
        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);
        $duree = $dateDebut->diffInDays($dateFin);

        // Vérifier la fréquence en fonction de la durée
        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return redirect()->back()->withErrors(['frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIERE ou HEBDOMADAIRE."])->withInput();
        }

        // Recalcul du nombre de cotisations
        $nbreCotisation = intval($request->montant_total / $request->montant_de_base);

        // Mise à jour des informations de la tontine
        $tontine->update([
            'frequence' => $request->frequence,
            'libelle' => $request->libelle,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'description' => $request->description,
            'montant_total' => $request->montant_total,
            'montant_de_base' => $request->montant_de_base,
            'nbre_participant' => $request->nbre_participant,
            'nbre_cotisation' => $nbreCotisation,
        ]);

        return redirect()->route('tontines.index')->with('success', 'Tontine mise à jour avec succès.');
    }

    // Supprimer une tontine
    public function destroy(Tontine $tontine)
    {
        $tontine->delete();
        return redirect()->route('tontines.index')->with('success', 'Tontine supprimée avec succès.');
    }
}
