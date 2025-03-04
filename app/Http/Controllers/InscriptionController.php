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
            'dateNaissance' => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'adresse' => 'required|string',
            'password' => 'required|min:6|confirmed',
            'cni' => 'min:5|max:5'
        ]);

        // Enregistrement dans la base de donnees
        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => bcrypt($request->password),
            'cni' => $request->cni
        ]);

        if($user) {
            $participant = new Participant();
            $participant->idUser = $user->id;
            $participant->dateNaissance = $request->dateNaissance;
            $participant->cni = $request->cni;
            $participant->adresse = $request->adresse;
            $participant->save();

            // Authentification
            $request->session()->regenerate();

            // Redirection vers la page d'accueil
            return redirect()->route('home');
        }

        return back()->with('error', "Une erreur s'est produite lors de l'enregistrement");
    }    

    public function home() {
        return view('welcome');
    }
}

