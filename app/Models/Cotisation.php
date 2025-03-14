<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RappelCotisation;

class Cotisation extends Model
{
    protected $fillable = [
        'id_user',
        'id_tontine',
        'montant',
        'moyen_paiement',
        'date_cotisation'
    ];

    protected $casts = [
        'date_cotisation' => 'datetime',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relation avec la tontine
    public function tontine()
    {
        return $this->belongsTo(Tontine::class, 'id_tontine');
    }

    /**
     * Vérifie si un participant a déjà payé pour la séance actuelle.
     */
    public function cotisationEffectuee()
    {
        $aujourdhui = Carbon::today();
        return Cotisation::where('id_user', $this->id_user)
            ->where('id_tontine', $this->id_tontine)
            ->whereDate('date_cotisation', $aujourdhui)
            ->exists();
    }

    /**
     * Vérifie si un participant a une séance en retard.
     */
    public function seanceEnRetard()
    {
        $tontine = $this->tontine;
        $dateDebut = Carbon::parse($tontine->date_debut);
        $aujourdhui = Carbon::today();

        if ($aujourdhui->greaterThan(Carbon::parse($tontine->date_fin))) {
            return false; // Tontine terminée, pas de rappel nécessaire
        }

        return !$this->cotisationEffectuee(); // Retard si la cotisation n'est pas enregistrée
    }

    /**
     * Envoie des rappels aux participants en retard ou une confirmation pour ceux qui ont déjà payé.
     */
    public static function envoyerRappels()
    {
        $tontines = Tontine::with('cotisations.user')->get();

        foreach ($tontines as $tontine) {
            foreach ($tontine->cotisations as $cotisation) {
                $participant = $cotisation->user;

                if ($participant->profil === 'PARTICIPANT') {
                    if ($cotisation->seanceEnRetard()) {
                        // Envoi d'un rappel pour retard
                        Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'rappel'));
                    } else {
                        // Envoi d'une confirmation avec la prochaine échéance
                        Mail::to($participant->email)->send(new RappelCotisation($participant, $tontine, 'confirmation'));
                    }
                }
            }
        }
    }
}