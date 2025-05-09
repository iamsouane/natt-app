<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tontine;
use App\Models\Cotisation;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
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

        if ($request->frequence === 'HEBDOMADAIRE' && $duree < 7) {
            return back()->withErrors([
                'frequence' => "Pour une fréquence HEBDOMADAIRE, la durée doit être d'au moins 7 jours."
            ])->withInput();
        }

        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return back()->withErrors([
                'frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIÈRE ou HEBDOMADAIRE."
            ])->withInput();
        }

        // Calcul du nombre de séances
        $nbSeances = match ($request->frequence) {
            'JOURNALIERE' => $duree + 1,
            'HEBDOMADAIRE' => floor(($duree + 1) / 7),
            'MENSUELLE' => $dateDebut->diffInMonths($dateFin) + 1,
        };

        if ($request->frequence === 'JOURNALIERE' && ($request->nbre_participant < 3 || $nbSeances < 4)) {
            return back()->withErrors([
                'date_fin' => "Pour une fréquence journalière, il faut au minimum 3 participants et une durée de 3 jours pour créer une tontine."
            ])->withInput();
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

        if ($request->frequence === 'HEBDOMADAIRE' && $duree < 7) {
            return back()->withErrors([
                'frequence' => "Pour une fréquence HEBDOMADAIRE, la durée doit être d'au moins 7 jours."
            ])->withInput();
        }

        if ($duree < 30 && !in_array($request->frequence, ['JOURNALIERE', 'HEBDOMADAIRE'])) {
            return back()->withErrors([
                'frequence' => "Pour une durée inférieure à 30 jours, la fréquence doit être JOURNALIÈRE ou HEBDOMADAIRE."
            ])->withInput();
        }

        $nbSeances = match ($request->frequence) {
            'JOURNALIERE' => $duree + 1,
            'HEBDOMADAIRE' => floor(($duree + 1) / 7),
            'MENSUELLE' => $dateDebut->diffInMonths($dateFin) + 1,
        };

        if ($nbSeances < $request->nbre_participant) {
            return back()->withErrors([
                'date_fin' => "La durée choisie ne permet pas d'organiser au moins autant de séances que de participants ({$nbSeances} séances possibles pour {$request->nbre_participant} participants)."
            ])->withInput();
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

        if ($request->hasFile('images')) {
            foreach ($tontine->images as $image) {
                Storage::disk('public')->delete($image->chemin_image);
                $image->delete();
            }

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
                $nbTirages = $tontine->tirages()->count();
                if ($nbTirages >= $tontine->nbre_cotisation) {
                    Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'terminee'));
                    continue;
                }

                $cotisation = Cotisation::where('id_user', $participant->id)
                    ->where('id_tontine', $tontine->id)
                    ->first();

                $type = (!$cotisation || $cotisation->seanceEnRetard()) ? 'rappel' : 'confirmation';
                Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, $type));

                sleep(2);
            }
        }

        return redirect()->route('tontines.index')->with('success', 'Les emails ont été envoyés avec succès.');
    }

    public function promouvoirGerant(Request $request, Tontine $tontine)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $tontine->gerants()->syncWithoutDetaching([$user->id]);

        return redirect()->back()->with('success', 'Participant promu gérant avec succès.');
    }

    public function sendMailsGerant($tontine_id)
    {
        $tontine = Tontine::with(['participants.user', 'gerants'])->findOrFail($tontine_id);
        $user = auth()->user();

        if (!$tontine->gerants->contains($user->id)) {
            abort(403, "Vous n'êtes pas autorisé à envoyer des mails pour cette tontine.");
        }

        $nbTirages = $tontine->tirages()->count();
        $estTerminee = $nbTirages >= $tontine->nbre_cotisation;

        foreach ($tontine->participants as $participant) {
            $type = 'confirmation';

            if ($estTerminee) {
                $type = 'terminee';
            } else {
                $cotisation = Cotisation::where('id_user', $participant->user->id)
                    ->where('id_tontine', $tontine->id)
                    ->first();

                if (!$cotisation || $cotisation->seanceEnRetard()) {
                    $type = 'rappel';
                }
            }

            Mail::to($participant->user->email)
                ->send(new RappelCotisation($participant, $tontine, $type));

            sleep(2);
        }

        return redirect()->route('tontines.show', $tontine->id)->with('success', 'Les emails ont été envoyés avec succès.');
    }
}