<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tirage;

class TirageController extends Controller
{
    // Afficher la liste des tirages
    public function index()
    {
        $tirages = Tirage::with(['user', 'tontine'])->get();
        return view('tirages.index', compact('tirages'));
    }

    // Afficher le formulaire de création d'un tirage
    public function create()
    {
        $tontines = Tontine::all();
        $users = User::where('profil', 'PARTICIPANT')->get();
        return view('tirages.create', compact('tontines', 'users'));
    }

    // Enregistrer un nouveau tirage
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_tontine' => 'required|exists:tontines,id',
        ]);

        // Vérifier si l'utilisateur a déjà gagné dans cette tontine
        $existingTirage = Tirage::where('id_user', $request->id_user)
            ->where('id_tontine', $request->id_tontine)
            ->exists();

        if ($existingTirage) {
            return redirect()->back()->withErrors(['error' => 'Cet utilisateur a déjà gagné dans cette tontine.']);
        }

        Tirage::create($request->all());
        return redirect()->route('tirages.index')->with('success', 'Tirage enregistré avec succès.');
    }

    // Afficher les détails d'un tirage
    public function show(Tirage $tirage)
    {
        return view('tirages.show', compact('tirage'));
    }

    // Afficher le formulaire de modification d'un tirage
    public function edit(Tirage $tirage)
    {
        $tontines = Tontine::all();
        $users = User::where('profil', 'PARTICIPANT')->get();
        return view('tirages.edit', compact('tirage', 'tontines', 'users'));
    }

    // Mettre à jour un tirage
    public function update(Request $request, Tirage $tirage)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_tontine' => 'required|exists:tontines,id',
        ]);

        $tirage->update($request->all());
        return redirect()->route('tirages.index')->with('success', 'Tirage mis à jour avec succès.');
    }

    // Supprimer un tirage
    public function destroy(Tirage $tirage)
    {
        $tirage->delete();
        return redirect()->route('tirages.index')->with('success', 'Tirage supprimé avec succès.');
    }
}
