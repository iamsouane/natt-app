<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = 'SUPER_ADMIN,GERANT'): Response
    {
        // Vérifier si l'utilisateur est connecté et a le bon rôle
        if (auth()->check() && in_array(auth()->user()->profil, explode(',', $role))) {
            return $next($request);
        }

        // Rediriger vers une page d'erreur ou la page d'accueil
        return redirect('/')->withErrors(['error' => 'Accès non autorisé.']);
    }
}
