<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tontine;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function promoteToGérant(Request $request, User $user)
    {
        // Vérifier que l'utilisateur est bien un PARTICIPANT
        if ($user->profil !== 'PARTICIPANT') {
            return back()->with('error', 'Seuls les participants peuvent être promus.');
        }

        // Vérifier que la tontine existe
        $tontine = Tontine::find($request->tontine_id);
        if (!$tontine) {
            return back()->with('error', 'Tontine non trouvée.');
        }

        // Vérifier que le participant appartient bien à cette tontine
        if (!$tontine->participants->contains($user->id)) {
            return back()->with('error', 'Ce participant ne fait pas partie de cette tontine.');
        }

        // Promouvoir le participant en GERANT
        $user->update(['profil' => 'GERANT']);

        // Ajouter l'association entre le GERANT et la tontine
        $user->tontinesGerant()->attach($tontine->id);

        return back()->with('success', 'Participant promu en gérant avec succès.');
    }
}