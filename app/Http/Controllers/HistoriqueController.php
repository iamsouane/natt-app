<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tontine;
use App\Models\Cotisation;

class HistoriqueController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cotisations = $user->cotisations ?? collect();
        $tirages = $user->tirages ?? collect();

        // Récupérer les tontines via les cotisations
        $tontines = $cotisations
            ->load('tontine') // charge les tontines liées
            ->pluck('tontine')
            ->unique('id')
            ->filter(); // supprime les tontines nulles si jamais

        return view('participant.historique.index', compact('cotisations', 'tirages', 'tontines'));
    }
}