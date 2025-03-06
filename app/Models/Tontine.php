<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
}
