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
                <a href="{{ route('participant.cotisations.create', $tontine) }}" class="btn btn-success">Participer</a>
                <a href="{{ route('participant.tontines.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection