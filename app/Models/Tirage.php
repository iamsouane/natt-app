<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tirage extends Model
{
    protected $fillable = ['id_user', 'id_tontine', 'numero_seance'];

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
