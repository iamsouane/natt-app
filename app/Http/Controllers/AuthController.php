<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function create() {
        return view('pages.auth.auth');
    }

    public function auth(Request $request) {
        $auth = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($auth)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->with('error', "Email et/ou mot de passe incorrect");
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
