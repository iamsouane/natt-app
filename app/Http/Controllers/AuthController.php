<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function create()
    {
        return view('pages.auth.auth');
    }

    // Gérer la connexion
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Rediriger en fonction du profil de l'utilisateur
            if (auth()->user()->profil === 'SUPER_ADMIN') {
                return redirect()->route('tontines.index'); // Redirection pour SUPER_ADMIN
            } elseif (auth()->user()->profil === 'GERANT') {
                return redirect()->route('tontines.index'); // Redirection pour GERANT
            } else {
                return redirect()->route('home'); // Redirection par défaut
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    // Gérer la déconnexion
    public function logout(Request $request)
    {
        Auth::logout(); // Déconnecter l'utilisateur
        $request->session()->invalidate(); // Invalider la session
        $request->session()->regenerateToken(); // Régénérer le jeton CSRF
        return redirect('/'); // Rediriger vers la page d'accueil
    }
}