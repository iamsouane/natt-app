<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\User;

class InscriptionController extends Controller
{
    // Permet d'acceder a la vue inscription
    public function index() {
        return view('pages.inscription.index');
    }

    // Valider le formulaire
    public function register(Request $request) {
        $request->validate([
            'prenom' => 'required|min:3',
            'nom' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|max:9|unique:users',
            'date_naissance' => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'adresse' => 'required|string',
            'password' => 'required|min:6|confirmed',
            'cni' => 'nullable|min:5|max:5|unique:participants' // Champ optionnel
        ]);
    
        // Enregistrement dans la base de donnees
        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            //'cni' => $request->cni // Ajoutez cni à la table users si nécessaire
        ]);
    
        if ($user) {
            $participant = new Participant();
            $participant->id_user = $user->id;
            $participant->date_naissance = $request->date_naissance;
            $participant->cni = $request->cni ?? 'N/A'; // Valeur par défaut si cni est null
            $participant->adresse = $request->adresse;
            $participant->save();
    
            // Authentification
            $request->session()->regenerate();
    
            // Redirection vers la page de connexion
            return redirect()->route('auth.create');
        }
    
        return back()->with('error', "Une erreur s'est produite lors de l'enregistrement");
    }   

    public function home() {
        return view('welcome');
    }
}

