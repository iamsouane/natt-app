<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tirage;
use App\Models\Tontine;
use App\Models\User;

class TirageController extends Controller
{
    // Afficher la liste des tontines disponibles pour le tirage
    public function index()
{
    // Récupérer toutes les tontines disponibles
    $tontines = Tontine::all();

    // Récupérer tous les tirages avec les informations de la tontine et du gagnant
    $tirages = Tirage::with(['tontine', 'user'])->get();

    // Passer les tontines et les tirages à la vue
    return view('tirages.index', compact('tontines', 'tirages'));
}


    // Afficher le formulaire de création d'un tirage pour une tontine spécifique
    public function create(Request $request)
    {
        // Récupérer la tontine sélectionnée
        $tontine = Tontine::findOrFail($request->get('tontine_id'));

        // Récupérer les utilisateurs ayant le profil "PARTICIPANT"
        $users = User::where('profil', 'PARTICIPANT')->get();

        return view('tirages.create', compact('tontine', 'users'));
    }

    // Enregistrer un nouveau tirage
    public function store(Request $request)
{
    // Récupérer la tontine concernée
    $tontine = Tontine::findOrFail($request->id_tontine);

    // Récupérer les participants qui n'ont pas encore gagné dans cette tontine
    $participantsEligibles = User::where('profil', 'PARTICIPANT')
        ->whereDoesntHave('tirages', function ($query) use ($tontine) {
            $query->where('id_tontine', $tontine->id);
        })
        ->get();

    // Vérifier s'il y a des participants éligibles
    if ($participantsEligibles->isEmpty()) {
        return redirect()->back()->with('error', 'Tous les participants ont déjà gagné un tirage.');
    }

    // Sélectionner un gagnant au hasard
    $gagnant = $participantsEligibles->random();

    // Créer et enregistrer le tirage avec le gagnant
    $tirage = Tirage::create([
        'id_user' => $gagnant->id,
        'id_tontine' => $tontine->id,
        'date_tirage' => now(),
    ]);

    // Rediriger avec le nom du gagnant affiché
    return redirect()->route('tirages.index')->with('success', "Le tirage a été effectué. Le gagnant est : {$gagnant->name}");
}


    // Afficher les détails d'un tirage
    public function show(Tirage $tirage)
    {
        return view('tirages.show', compact('tirage'));
    }

    // Modifier un tirage existant
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
