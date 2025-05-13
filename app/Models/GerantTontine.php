<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GerantTontine extends Model
{
    use HasFactory;

    // Nom explicite de la table
    protected $table = 'gerants_tontines';

    // Champs pouvant être remplis en masse
    protected $fillable = [
        'tontine_id',
        'user_id',
    ];

    /**
     * L'utilisateur (gérant) associé à cette entrée.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * La tontine associée à cette entrée.
     */
    public function tontine()
    {
        return $this->belongsTo(Tontine::class, 'id_tontine');
    }
}