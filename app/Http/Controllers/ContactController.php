<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Vérification redondante (bonne pratique)
        if (!Auth::check()) {
            return redirect()->route('auth.create')
                ->with('error', 'Vous devez être connecté pour envoyer un message.');
        }

        $request->validate([
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        $details = [
            'name' => $user->name,
            'email' => $user->email, // Utilise l'email du compte connecté
            'subject' => $request->subject,
            'body' => $request->message,
        ];

        try {
            Mail::mailer('gmail')
                ->to('ismailasouane08@gmail.com')
                ->send(new \App\Mail\ContactMessage($details));

            return back()->with('success', 'Votre message a été envoyé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi du message: '.$e->getMessage());
        }
    }
}