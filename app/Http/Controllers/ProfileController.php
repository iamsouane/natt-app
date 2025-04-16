<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('participant.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;

        // 🔒 Mise à jour du mot de passe uniquement si fourni
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // 🖼️ Mise à jour de l'image si l'utilisateur est un participant
        if ($user->participant && $request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cni_images', 'public');
            $user->participant->image_cni = $imagePath;
            $user->participant->save();
        }

        // 🔁 Reconnexion de l'utilisateur pour que les données soient mises à jour
        auth()->login($user);

        return redirect()->route('participant.profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }
}