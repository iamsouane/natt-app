<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tontine;
use App\Models\User;

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

            // Récupérer les tontines actives
            $tontines = Tontine::where('date_fin', '>', now())->get();

            // Rediriger en fonction du profil de l'utilisateur
            if (auth()->user()->profil === 'SUPER_ADMIN' || auth()->user()->profil === 'GERANT') {
                return redirect()->route('tontines.index'); 
            } else {
                return redirect()->route('home')->with('tontines', $tontines);
            }
        }

        return back()->withErrors([
            'login' => 'Les identifiants fournis sont incorrects. Veuillez réessayer.',
        ])->withInput();
    }

    // Gérer la déconnexion
    public function logout(Request $request)
    {
        Auth::logout(); // Déconnecter l'utilisateur
        $request->session()->invalidate(); // Invalider la session
        $request->session()->regenerateToken(); // Régénérer le jeton CSRF
        return redirect('/'); // Rediriger vers la page d'accueil
    }

    // Afficher le formulaire d'email pour la réinitialisation
    public function showForgotPasswordForm()
    {
        return view('pages.auth.forgot-password');
    }

    // Vérifier si l'email existe et rediriger
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Aucun compte trouvé avec cet email.');
        }

        // Redirection vers le formulaire de réinitialisation
        return redirect()->route('password.reset', ['email' => $user->email]);
    }

    // Afficher le formulaire de nouveau mot de passe
    public function showResetForm($email)
    {
        return view('pages.auth.reset-password', compact('email'));
    }

    // Mettre à jour le mot de passe
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('auth.create')->with('success', 'Mot de passe mis à jour avec succès.');
    }
}