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
     * Calcule le nombre total de cotisations en fonction de la durée et de la fréquence
     */
    public function calculerNbreCotisation()
    {
        $dateDebut = Carbon::parse($this->date_debut);
        $dateFin = Carbon::parse($this->date_fin);
        $duree = $dateDebut->diffInDays($dateFin); // Durée en jours

        if ($duree <= 0) {
            throw new \Exception("La durée de la tontine doit être supérieure à zéro.");
        }

        switch ($this->frequence) {
            case 'JOURNALIERE':
                $this->nbre_cotisation = $duree;
                break;
            case 'HEBDOMADAIRE':
                $this->nbre_cotisation = ceil($duree / 7);
                break;
            case 'MENSUELLE':
                $this->nbre_cotisation = ceil($duree / 30);
                break;
            default:
                throw new \Exception("Fréquence invalide. Elle doit être JOURNALIERE, HEBDOMADAIRE ou MENSUELLE.");
        }

        if ($this->montant_total <= 0) {
            throw new \Exception("Le montant total doit être supérieur à zéro.");
        }
    }

    /**
     * Retourne le nombre de cotisations restantes
     */
    public function cotisationsRestantes()
    {
        return $this->nbre_cotisation - $this->cotisations()->count();
    }
}