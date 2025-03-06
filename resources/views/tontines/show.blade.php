@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de la Tontine</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $tontine->libelle }}</h5>
                <p class="card-text"><strong>Fréquence :</strong> {{ $tontine->frequence }}</p>
                <p class="card-text"><strong>Date de début :</strong> {{ $tontine->date_debut }}</p>
                <p class="card-text"><strong>Date de fin :</strong> {{ $tontine->date_fin }}</p>
                <p class="card-text"><strong>Description :</strong> {{ $tontine->description }}</p>
                <p class="card-text"><strong>Montant total :</strong> {{ $tontine->montant_total }}</p>
                <p class="card-text"><strong>Montant de base :</strong> {{ $tontine->montant_de_base }}</p>
                <p class="card-text"><strong>Nombre de participants :</strong> {{ $tontine->nbre_participant }}</p>
                <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
        <a href="{{ route('tontines.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>
@endsection