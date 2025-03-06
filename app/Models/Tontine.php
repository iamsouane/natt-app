<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    // Relation avec les cotisations
    public function cotisations()
    {
        return $this->hasMany(Cotisation::class, 'id_tontine');
    }

    // Relation avec les tirages
    public function tirages()
    {
        return $this->hasMany(Tirage::class, 'id_tontine');
    }

    // Relation avec les images
    public function images()
    {
        return $this->hasMany(Image::class, 'id_tontine');
    }
}