<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;
use App\Models\Cotisation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RappelCotisation;
use App\Models\User;
use App\Notifications\RappelCotisationNotification;

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

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);
        $duree = $dateDebut->diffInDays($dateFin);

        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return redirect()->back()->withErrors(['frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIERE ou HEBDOMADAIRE."])->withInput();
        }

        $nbreCotisation = intval($request->montant_total / $request->montant_de_base);

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

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);
        $duree = $dateDebut->diffInDays($dateFin);

        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return redirect()->back()->withErrors(['frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIERE ou HEBDOMADAIRE."])->withInput();
        }

        $nbreCotisation = intval($request->montant_total / $request->montant_de_base);

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

    // Envoi des emails et notifications pour la cotisation
    public function sendEmails()
    {
        $participants = User::where('profil', 'PARTICIPANT')->get();
        $tontines = Tontine::all();

        foreach ($participants as $participant) {
            foreach ($tontines as $tontine) {
                $cotisation = Cotisation::where('id_user', $participant->id)
                                        ->where('id_tontine', $tontine->id)
                                        ->first();

                // Envoi de la notification (indépendant de Mailtrap)
                if (!$cotisation || ($cotisation && $cotisation->seanceEnRetard())) {
                    // Envoi de la notification pour le retard
                    $participant->notify(new RappelCotisationNotification($participant, $tontine, 'rappel'));
                } else {
                    // Envoi de la notification de confirmation
                    $participant->notify(new RappelCotisationNotification($participant, $tontine, 'confirmation'));
                }

                // Essayer d'envoyer l'email même si le plan Mailtrap est épuisé
                try {
                    if (!$cotisation || ($cotisation && $cotisation->seanceEnRetard())) {
                        // Envoi email rappel
                        Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'rappel'));
                    } else {
                        // Envoi email confirmation
                        Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'confirmation'));
                    }
                } catch (\Exception $e) {
                    // Gérer l'exception (plan Mailtrap épuisé), mais les notifications seront envoyées
                    // Vous pouvez également enregistrer l'exception dans les logs si nécessaire
                    Log::error('Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());
                }

                // Petite pause pour éviter d’être considéré comme spam
                sleep(3);
            }
        }

        return redirect()->route('tontines.index')->with('success', 'Les emails et notifications ont été envoyés avec succès.');
    }
}