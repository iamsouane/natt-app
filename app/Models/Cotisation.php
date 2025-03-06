<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_user',
        'id_tontine',
        'montant',
        'moyen_paiement'
    ];
}
