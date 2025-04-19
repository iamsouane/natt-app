@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center" data-aos="fade-up" data-aos-duration="1000">
                <!-- En-tête avec animation -->
                <div class="jumbotron jumbotron-fluid" style="background: linear-gradient(135deg, #0077b6, #00b4d8); color: #fff;" data-aos="zoom-in" data-aos-duration="1500">
                    <div class="container">
                        <h1 class="display-4 font-weight-bold">Bienvenue sur Natt-app</h1>
                        <p class="lead">Une plateforme pour gérer vos tontines en toute simplicité.</p>
                    </div>
                </div>

                @auth
                    <!-- Message pour les utilisateurs connectés -->
                    <div class="card shadow-sm" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                        <div class="card-body">
                            <h3 class="mb-4">Bonjour, {{ auth()->user()->prenom }} {{ auth()->user()->nom }} !</h3>

                            <!-- Afficher un lien vers la page tontine pour les participants -->
                            @if (auth()->user()->profil === 'PARTICIPANT')
                                <h4>Choisissez une tontine pour cotiser</h4>
                                <p>Vous pouvez voir toutes les tontines disponibles et cotiser en cliquant sur le lien ci-dessous :</p>
                                <a href="{{ route('participant.index') }}" class="btn btn-primary btn-lg">Voir les tontines disponibles</a>
                            @endif

                            <!-- Liens pour les utilisateurs connectés -->
                            <div class="mt-4">
                                @if (auth()->user()->profil === 'SUPER_ADMIN' || auth()->user()->profil === 'GERANT')
                                    <a href="{{ route('tontines.index') }}" class="btn btn-primary btn-lg mr-3">Gérer les tontines</a>
                                    <a href="{{ route('tirages.index') }}" class="btn btn-primary btn-lg mr-3">Gérer les tirages</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Message pour les utilisateurs non connectés -->
                    <div class="card shadow-sm" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                        <div class="card-body">
                            <p class="lead">Veuillez vous connecter ou vous inscrire pour accéder à l'application.</p>

                            <!-- Liens pour les utilisateurs non connectés -->
                            <div class="mt-4">
                                <a href="{{ route('auth.create') }}" class="btn btn-primary btn-lg mr-3">Se connecter</a>
                                <a href="{{ route('inscription.index') }}" class="btn btn-success btn-lg">S'inscrire</a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection