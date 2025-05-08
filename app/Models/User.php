<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'prenom',
        'nom',
        'telephone',
        'email',
        'password',
        'profil'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relation avec les cotisations
    public function cotisations()
    {
        return $this->hasMany(Cotisation::class, 'id_user');
    }

    // Relation avec les tirages
    public function tirages()
    {
        return $this->hasMany(Tirage::class, 'id_user');
    }

    // Relation avec le profil participant
    public function participant()
    {
        return $this->hasOne(Participant::class, 'id_user');
    }

    public function tontinesGerant()
    {
        return $this->belongsToMany(Tontine::class, 'gerants_tontines', 'gerant_id', 'tontine_id');
    }

    public function tontinesGerees()
    {
        return $this->belongsToMany(Tontine::class, 'gerants_tontines', 'gerant_id', 'tontine_id');
    }
}