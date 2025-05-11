<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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

    public function participants()
    {
        return $this->hasManyThrough(Participant::class, Cotisation::class, 'id_tontine', 'id_user', 'id', 'id_user');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'id_tontine');
    }

    public function tirages()
    {
        return $this->hasMany(Tirage::class, 'id_tontine');
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
     * Retourne le nombre de cotisations restantes pour un participant donné.
     */
    public function cotisationsRestantesPourParticipant($userId)
    {
        $cotisationsEffectuees = Cotisation::where('id_user', $userId)
            ->where('id_tontine', $this->id)
            ->count();

        return max(0, $this->nbre_cotisation - $cotisationsEffectuees);
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

    // Dans le modèle Tontine

    public function canCotiser()
    {
        // Récupérer la dernière cotisation de l'utilisateur
        $dernierPaiement = $this->cotisations()
            ->where('id_user', Auth::id())
            ->latest('date_cotisation')
            ->first();

        // Si aucun paiement n'a été effectué, vérifier si la date de début permet la cotisation
        if (!$dernierPaiement) {
            return Carbon::now()->greaterThanOrEqualTo($this->date_debut);
        }

        // Sinon, vérifier la date de la prochaine cotisation en fonction de la fréquence
        switch ($this->frequence) {
            case 'JOURNALIERE':
                return Carbon::parse($dernierPaiement->date_cotisation)->addDay()->lessThanOrEqualTo(Carbon::now());
            case 'HEBDOMADAIRE':
                return Carbon::parse($dernierPaiement->date_cotisation)->addWeek()->lessThanOrEqualTo(Carbon::now());
            case 'MENSUELLE':
                return Carbon::parse($dernierPaiement->date_cotisation)->addMonth()->lessThanOrEqualTo(Carbon::now());
            default:
                return false; // Fréquence invalide ou non définie
        }
    }

    public function participantsActifs()
    {
        return User::whereIn('id', function ($query) {
            $query->select('id_user')
                ->from('cotisations')
                ->where('id_tontine', $this->id)
                ->groupBy('id_user');
        })->get();
    }

    public function gerants()
    {
        return $this->belongsToMany(User::class, 'gerants_tontines', 'tontine_id', 'gerant_id');
    }

    /**
     * Vérifie si l'utilisateur connecté est gérant de cette tontine.
     *
     * @return bool
     */
    public function estGerant()
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $this->gerants()->where('gerant_id', $user->id)->exists();
    }


    public function estTerminee()
    {
        $nbCotisationsEffectuees = $this->cotisations()->distinct('numero_seance')->count('numero_seance');
        return $nbCotisationsEffectuees >= $this->nbre_cotisation;
    }

}