@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails du Tirage</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tirage #{{ $tirage->id }}</h5>
                <p class="card-text"><strong>Tontine :</strong> {{ $tirage->tontine->libelle }}</p>
                <p class="card-text"><strong>Gagnant :</strong> {{ $tirage->user->prenom }} {{ $tirage->user->nom }}</p>
                <p class="card-text"><strong>Date du tirage :</strong> {{ $tirage->date_tirage }}</p>
                <a href="{{ route('tirages.edit', $tirage) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('tirages.destroy', $tirage) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce tirage ?')">Supprimer</button>
                </form>
            </div>
        </div>
        <a href="{{ route('tirages.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>
@endsection