<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Affiche les notifications de l'utilisateur.
     */
    public function index()
    {
        // Récupère les notifications de l'utilisateur connecté, triées par date décroissante
        $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->get();

        // Retourne la vue avec les notifications
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marque une notification comme lue.
     */
    public function markAsRead($id)
    {
        // Récupère la notification spécifique
        $notification = auth()->user()->notifications()->findOrFail($id);

        // Marque la notification comme lue
        $notification->markAsRead(); // méthode native Laravel

        // Retourne à la liste des notifications avec un message de succès
        return redirect()->route('notifications.index')->with('success', 'Notification marquée comme lue.');
    }
}