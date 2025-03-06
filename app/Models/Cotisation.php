<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    protected $fillable = [
        'id_user',
        'id_tontine',
        'montant',
        'moyen_paiement'
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
}