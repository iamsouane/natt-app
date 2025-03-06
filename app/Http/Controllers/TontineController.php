<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;


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
            'frequence' => 'required',
            'libelle' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'description' => 'required',
            'montant_total' => 'required|numeric',
            'montant_de_base' => 'required|numeric',
            'nbre_participant' => 'required|integer',
        ]);

        Tontine::create($request->all());
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
            'frequence' => 'required',
            'libelle' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'description' => 'required',
            'montant_total' => 'required|numeric',
            'montant_de_base' => 'required|numeric',
            'nbre_participant' => 'required|integer',
        ]);

        $tontine->update($request->all());
        return redirect()->route('tontines.index')->with('success', 'Tontine mise à jour avec succès.');
    }

    // Supprimer une tontine
    public function destroy(Tontine $tontine)
    {
        $tontine->delete();
        return redirect()->route('tontines.index')->with('success', 'Tontine supprimée avec succès.');
    }
}
