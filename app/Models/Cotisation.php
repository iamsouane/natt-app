<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
        'date_cotisation' => 'datetime', // Permet d'utiliser format() directement
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

    // Vérifie si un participant a une cotisation en retard
    public function cotisationEnRetard()
    {
        $tontine = $this->tontine;
        $dernierPaiement = Cotisation::where('id_user', $this->id_user)
            ->where('id_tontine', $tontine->id)
            ->latest('date_cotisation')
            ->first();

        // Déterminer la prochaine date de cotisation
        $prochaineCotisation = $dernierPaiement
            ? $dernierPaiement->date_cotisation
            : $tontine->date_debut;

        switch ($tontine->frequence) {
            case 'JOURNALIERE':
                $prochaineCotisation = Carbon::parse($prochaineCotisation)->addDay();
                break;
            case 'HEBDOMADAIRE':
                $prochaineCotisation = Carbon::parse($prochaineCotisation)->addWeek();
                break;
            case 'MENSUELLE':
                $prochaineCotisation = Carbon::parse($prochaineCotisation)->addMonth();
                break;
        }

        return Carbon::now()->greaterThan($prochaineCotisation);
    }

    // Envoie un rappel de cotisation
    public static function envoyerRappels()
    {
        $tontines = Tontine::with('cotisations.user')->get();

        foreach ($tontines as $tontine) {
            foreach ($tontine->cotisations as $cotisation) {
                $participant = $cotisation->user;

                if ($participant && $cotisation->cotisationEnRetard()) {
                    Mail::to($participant->email)->send(new \App\Mail\RappelCotisation($participant, $tontine));
                }
            }
        }
    }
}