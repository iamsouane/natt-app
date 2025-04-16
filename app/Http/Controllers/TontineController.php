<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;
use App\Models\Cotisation;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TontineEmails;
use App\Mail\RappelCotisation;
use Illuminate\Support\Facades\Storage;

class TontineController extends Controller
{
    public function index()
    {
        $tontines = Tontine::all();
        return view('tontines.index', compact('tontines'));
    }

    public function voirPourParticipant()
    {
        $tontines = Tontine::with('participants')->get();
        return view('participant.index', compact('tontines'));
    }

    public function create()
    {
        return view('tontines.create');
    }

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
            'images.*' => 'nullable|image|max:2048',
        ]);

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);
        $duree = $dateDebut->diffInDays($dateFin);

        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return redirect()->back()->withErrors(['frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIERE ou HEBDOMADAIRE."])->withInput();
        }

        $nbreCotisation = intval($request->montant_total / $request->montant_de_base);

        $tontine = Tontine::create([
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

        // Gérer l'upload des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('tontines', 'public');
                Image::create([
                    'id_tontine' => $tontine->id,
                    'nom_image' => $img->getClientOriginalName(),
                    'chemin_image' => $path,
                ]);
            }
        }

        return redirect()->route('tontines.index')->with('success', 'Tontine créée avec succès.');
    }

    public function show(Tontine $tontine)
    {
        return view('tontines.show', compact('tontine'));
    }

    public function edit(Tontine $tontine)
    {
        return view('tontines.edit', compact('tontine'));
    }

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
            'images.*' => 'nullable|image|max:2048',
        ]);

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);
        $duree = $dateDebut->diffInDays($dateFin);

        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return redirect()->back()->withErrors(['frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIERE ou HEBDOMADAIRE."])->withInput();
        }

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

        // Supprimer les anciennes images et les remplacer
        if ($request->hasFile('images')) {
            // Supprimer les anciennes images
            foreach ($tontine->images as $image) {
                Storage::disk('public')->delete($image->chemin_image);
                $image->delete();
            }

            // Ajouter de nouvelles images
            foreach ($request->file('images') as $img) {
                $path = $img->store('tontines', 'public');
                Image::create([
                    'id_tontine' => $tontine->id,
                    'nom_image' => $img->getClientOriginalName(),
                    'chemin_image' => $path,
                ]);
            }
        }

        return redirect()->route('tontines.index')->with('success', 'Tontine mise à jour avec succès.');
    }

    public function destroy(Tontine $tontine)
    {
        // Supprimer les images liées
        foreach ($tontine->images as $image) {
            Storage::disk('public')->delete($image->chemin_image);
            $image->delete();
        }

        $tontine->delete();

        return redirect()->route('tontines.index')->with('success', 'Tontine supprimée avec succès.');
    }

    public function sendEmails()
    {
        $participants = User::where('profil', 'PARTICIPANT')->get();
        $tontines = Tontine::all();

        foreach ($participants as $participant) {
            foreach ($tontines as $tontine) {
                $cotisation = Cotisation::where('id_user', $participant->id)
                    ->where('id_tontine', $tontine->id)
                    ->first();

                if (!$cotisation || $cotisation->seanceEnRetard()) {
                    Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'rappel'));
                } else {
                    Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'confirmation'));
                }

                sleep(3); // Petite pause entre les envois
            }
        }

        return redirect()->route('tontines.index')->with('success', 'Les emails ont été envoyés avec succès.');
    }
}