<?php

namespace App\Policies;

use App\Models\Tontine;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TontinePolicy
{
    use HandlesAuthorization;

    /**
     * Déterminer si l'utilisateur peut créer une tontine.
     */
    public function create(User $user)
    {
        // Logique pour vérifier si l'utilisateur peut créer une tontine
        return in_array($user->profil, ['SUPER_ADMIN', 'GERANT']);
    }

    /**
     * Déterminer si l'utilisateur peut modifier une tontine.
     */
    public function update(User $user, Tontine $tontine)
    {
        // Logique pour vérifier si l'utilisateur peut modifier une tontine
        return in_array($user->profil, ['SUPER_ADMIN', 'GERANT']);
    }

    /**
     * Déterminer si l'utilisateur peut supprimer une tontine.
     */
    public function delete(User $user, Tontine $tontine)
    {
        // Logique pour vérifier si l'utilisateur peut supprimer une tontine
        return in_array($user->profil, ['SUPER_ADMIN', 'GERANT']);
    }

    public function sendEmails(User $user)
    {
        // Vérifie si l'utilisateur a le profil SUPER_ADMIN ou GERANT
        return in_array($user->profil, ['SUPER_ADMIN', 'GERANT']);
    }
}