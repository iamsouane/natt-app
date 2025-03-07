@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="mb-4">Bienvenue sur Natt-app</h1>

                @auth
                    <!-- Message pour les utilisateurs connectés -->
                    <p class="lead">Bonjour, {{ auth()->user()->prenom }} {{ auth()->user()->nom }} !</p>

                    <!-- Afficher les tontines pour les participants -->
                    @if(auth()->user()->profil === 'PARTICIPANT' && session('tontines'))
                        <h3>Choisissez une Tontine pour cotiser</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Libellé</th>
                                    <th>Fréquence</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('tontines') as $tontine)
                                    <tr>
                                        <td>{{ $tontine->libelle }}</td>
                                        <td>{{ $tontine->frequence }}</td>
                                        <td>{{ $tontine->date_debut }}</td>
                                        <td>{{ $tontine->date_fin }}</td>
                                        <td>
                                            <a href="{{ route('participant.tontines.show', $tontine) }}" class="btn btn-info btn-sm">Choisir</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <!-- Liens pour les utilisateurs connectés -->
                    <div class="mt-4">
                        @if (auth()->user()->profil === 'SUPER_ADMIN' || auth()->user()->profil === 'GERANT')
                            <a href="{{ route('tontines.index') }}" class="btn btn-primary btn-lg mr-3">Gérer les Tontines</a>
                            <a href="{{ route('tirages.index') }}" class="btn btn-primary btn-lg mr-3">Gérer les Tirages</a>
                        @endif
                        <a href="{{ route('logout') }}" class="btn btn-danger btn-lg" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
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
