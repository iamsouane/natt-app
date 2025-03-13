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
}