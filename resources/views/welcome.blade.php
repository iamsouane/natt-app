@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="mb-4">Bienvenue sur Natt-app</h1>
                <p class="lead">Veuillez vous connecter ou vous inscrire pour accéder à l'application.</p>
                <div class="mt-4">
                    <a href="{{ route('auth.create') }}" class="btn btn-primary btn-lg mr-3">Se connecter</a>
                    <a href="{{ route('inscription.index') }}" class="btn btn-success btn-lg">S'inscrire</a>
                </div>
            </div>
        </div>
    </div>
@endsection