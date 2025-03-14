<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Relation avec les cotisations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cotisations(): HasMany
    {
        return $this->hasMany(Cotisation::class, 'id_tontine');
    }

    /**
     * Calcule le nombre total de cotisations en fonction de la durée et de la fréquence.
     */
    public function calculerNbreCotisation()
    {
        $dateDebut = Carbon::parse($this->date_debut);
        $dateFin = Carbon::parse($this->date_fin);

        if ($dateDebut->greaterThanOrEqualTo($dateFin)) {
            throw new \Exception("La date de fin doit être postérieure à la date de début.");
        }

        $duree = $dateDebut->diffInDays($dateFin); // Durée en jours

        switch ($this->frequence) {
            case 'JOURNALIERE':
                $nbreCotisation = $duree;
                break;
            case 'HEBDOMADAIRE':
                $nbreCotisation = ceil($duree / 7);
                break;
            case 'MENSUELLE':
                $nbreCotisation = ceil($duree / 30);
                break;
            default:
                throw new \Exception("Fréquence invalide. Elle doit être JOURNALIERE, HEBDOMADAIRE ou MENSUELLE.");
        }

        $this->nbre_cotisation = max(0, $nbreCotisation); // Empêcher les valeurs négatives
    }

    /**
     * Retourne le nombre de cotisations restantes.
     */
    public function cotisationsRestantes()
    {
        return max(0, $this->nbre_cotisation - $this->cotisations()->count());
    }

    /**
     * Récupère la séance actuelle en fonction de la fréquence et de la date du jour.
     */
    public function getSeanceActuelle()
    {
        $dateDebut = Carbon::parse($this->date_debut);
        $aujourdhui = Carbon::today();

        switch ($this->frequence) {
            case 'JOURNALIERE':
                return $dateDebut->diffInDays($aujourdhui) + 1;
            case 'HEBDOMADAIRE':
                return $dateDebut->diffInWeeks($aujourdhui) + 1;
            case 'MENSUELLE':
                return $dateDebut->diffInMonths($aujourdhui) + 1;
            default:
                return null;
        }
    }

    /**
     * Récupère la prochaine date de cotisation
     *
     * @return Carbon|null
     */
    public function getDateProchaineCotisationAttribute()
    {
        // Dernière cotisation du participant
        $dernierPaiement = $this->cotisations()->latest('date_cotisation')->first();

        // Si aucune cotisation, la prochaine date est la date de début de la tontine
        $prochaineCotisation = $dernierPaiement ? $dernierPaiement->date_cotisation : $this->date_debut;

        // Vérifier si la date est définie avant d'appliquer les calculs
        if (!$prochaineCotisation) {
            return null;
        }

        // Calculer la prochaine cotisation en fonction de la fréquence
        switch ($this->frequence) {
            case 'JOURNALIERE':
                return Carbon::parse($prochaineCotisation)->addDay();
            case 'HEBDOMADAIRE':
                return Carbon::parse($prochaineCotisation)->addWeek();
            case 'MENSUELLE':
                return Carbon::parse($prochaineCotisation)->addMonth();
            default:
                return null; // Aucune fréquence définie
        }
    }
}