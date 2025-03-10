<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tontine extends Model
{
    protected $fillable = [
        'frequence',
        'libelle',
        'date_debut',
        'date_fin',
        'description',
        'montant_total',
        'montant_de_base',
        'nbre_participant',
        'nbre_cotisation',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tontine) {
            $tontine->calculerNbreCotisation();
        });

        static::updating(function ($tontine) {
            $tontine->calculerNbreCotisation();
        });
    }

    public function calculerNbreCotisation()
    {
        $dateDebut = Carbon::parse($this->date_debut);
        $dateFin = Carbon::parse($this->date_fin);
        $duree = $dateDebut->diffInDays($dateFin); // Durée en jours

        // Vérifier que la durée est positive
        if ($duree <= 0) {
            throw new \Exception("La durée de la tontine doit être supérieure à zéro.");
        }

        // Vérification de la fréquence et calcul du nombre de cotisations en fonction de celle-ci
        switch ($this->frequence) {
            case 'JOURNALIERE':
                // Une cotisation par jour
                $this->nbre_cotisation = $duree;
                break;

            case 'HEBDOMADAIRE':
                // Une cotisation par semaine
                $this->nbre_cotisation = ceil($duree / 7); // Arrondi à l'entier supérieur
                break;

            case 'MENSUELLE':
                // Une cotisation par mois
                $this->nbre_cotisation = ceil($duree / 30); // Environ 30 jours par mois
                break;

            default:
                throw new \Exception("Fréquence invalide. Elle doit être JOURNALIERE, HEBDOMADAIRE ou MENSUELLE.");
        }

        // Optionnel : Valider le montant total, peut-être selon votre logique de business
        if ($this->montant_total <= 0) {
            throw new \Exception("Le montant total doit être supérieur à zéro.");
        }
    }
}