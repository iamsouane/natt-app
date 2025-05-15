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

    protected $appends = ['progression', 'est_active', 'seances_effectuees', 'seances_totales, participants_count'];

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

    public function gerants()
    {
        return $this->belongsToMany(User::class, 'gerants_tontines', 'id_tontine', 'id_user');
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

        $duree = $dateDebut->diffInDays($dateFin);

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
                throw new \Exception("Fréquence invalide.");
        }

        $this->nbre_cotisation = max(0, $nbreCotisation);
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
     */
    public function getDateProchaineCotisationAttribute()
    {
        $dernierPaiement = $this->cotisations()->latest('date_cotisation')->first();
        $prochaineCotisation = $dernierPaiement ? $dernierPaiement->date_cotisation : $this->date_debut;

        if (!$prochaineCotisation) {
            return null;
        }

        switch ($this->frequence) {
            case 'JOURNALIERE':
                return Carbon::parse($prochaineCotisation)->addDay();
            case 'HEBDOMADAIRE':
                return Carbon::parse($prochaineCotisation)->addWeek();
            case 'MENSUELLE':
                return Carbon::parse($prochaineCotisation)->addMonth();
            default:
                return null;
        }
    }

    public function canCotiser()
    {
        $dernierPaiement = $this->cotisations()
            ->where('id_user', Auth::id())
            ->latest('date_cotisation')
            ->first();

        if (!$dernierPaiement) {
            return Carbon::now()->greaterThanOrEqualTo($this->date_debut);
        }

        switch ($this->frequence) {
            case 'JOURNALIERE':
                return Carbon::parse($dernierPaiement->date_cotisation)->addDay()->lessThanOrEqualTo(Carbon::now());
            case 'HEBDOMADAIRE':
                return Carbon::parse($dernierPaiement->date_cotisation)->addWeek()->lessThanOrEqualTo(Carbon::now());
            case 'MENSUELLE':
                return Carbon::parse($dernierPaiement->date_cotisation)->addMonth()->lessThanOrEqualTo(Carbon::now());
            default:
                return false;
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

    /**
     * Vérifie si l'utilisateur connecté est gérant
     */
    public function estGerant()
    {
        return $this->gerants()->where('id_user', Auth::id())->exists();
    }

    /**
     * Accesseurs pour la progression et le statut
     */
    public function getSeancesEffectueesAttribute()
    {
        return $this->cotisations()->distinct('numero_seance')->count('numero_seance');
    }

    public function getSeancesTotalesAttribute()
    {
        return $this->nbre_cotisation;
    }

    public function getProgressionAttribute()
    {
        if ($this->seances_totales == 0) {
            return 0;
        }
        return ($this->seances_effectuees / $this->seances_totales) * 100;
    }

    public function getEstActiveAttribute()
    {
        $now = Carbon::now();
        $dateDebut = Carbon::parse($this->date_debut);
        $dateFin = Carbon::parse($this->date_fin);
        
        return $now->greaterThanOrEqualTo($dateDebut) && 
               $now->lessThanOrEqualTo($dateFin) && 
               $this->seances_effectuees < $this->seances_totales;
    }

    public function getParticipantsCountAttribute()
    {
        return min(
            $this->cotisations()->distinct('id_user')->count('id_user'),
            $this->nbre_participant
        );
    }
}