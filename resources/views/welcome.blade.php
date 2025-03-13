@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="mb-4">Bienvenue sur Natt-app</h1>

                @auth
                    <!-- Message pour les utilisateurs connectés -->
                    <p class="lead">Bonjour, {{ auth()->user()->prenom }} {{ auth()->user()->nom }} !</p>

                    <!-- Afficher un lien vers la page cotisations pour les participants -->
                    @if (auth()->user()->profil === 'PARTICIPANT')
                        <h3>Choisissez une Tontine pour cotiser</h3>
                        <p>Vous pouvez voir toutes les tontines disponibles et cotiser en cliquant sur le lien ci-dessous :</p>

                        <a href="{{ route('participant.cotisations.index') }}" class="btn btn-primary btn-lg">Voir les Tontines disponibles</a>
                    @endif

                    <!-- Liens pour les utilisateurs connectés -->
                    <div class="mt-4">
                        @if (auth()->user()->profil === 'SUPER_ADMIN' || auth()->user()->profil === 'GERANT')
                            <a href="{{ route('tontines.index') }}" class="btn btn-primary btn-lg mr-3">Gérer les Tontines</a>
                            <a href="{{ route('tirages.index') }}" class="btn btn-primary btn-lg mr-3">Gérer les Tirages</a>
                        @endif
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-lg"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @else
                    <!-- Message pour les utilisateurs non connectés -->
                    <p class="lead">Veuillez vous connecter ou vous inscrire pour accéder à l'application.</p>

                    <!-- Liens pour les utilisateurs non connectés -->
                    <div class="mt-4">
                        <a href="{{ route('auth.create') }}" class="btn btn-primary btn-lg mr-3">Se connecter</a>
                        <a href="{{ route('inscription.index') }}" class="btn btn-success btn-lg">S'inscrire</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
