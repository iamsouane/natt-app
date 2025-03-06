<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'id_tontine', // Correction : 'id_tontine' au lieu de 'id_user'
        'nom_image'
    ];

    // Relation avec la tontine
    public function tontine()
    {
        return $this->belongsTo(Tontine::class, 'id_tontine');
    }
}