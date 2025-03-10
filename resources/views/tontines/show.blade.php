@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Détails de la Tontine</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $tontine->libelle }}</h5>
                <p class="card-text"><strong>Fréquence :</strong> {{ ucfirst(strtolower($tontine->frequence)) }}</p>
                <p class="card-text"><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</p>
                <p class="card-text"><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</p>
                <p class="card-text"><strong>Description :</strong> {{ $tontine->description }}</p>
                <p class="card-text"><strong>Montant total :</strong> {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
                <p class="card-text"><strong>Montant de base :</strong> {{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</p>
                <p class="card-text"><strong>Nombre de participants :</strong> {{ $tontine->nbre_participant }}</p>
                <p class="card-text"><strong>Nombre de cotisations :</strong> {{ $tontine->nbre_cotisation }}</p>

                <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning">Modifier</a>

                <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tontine ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>

        <a href="{{ route('tontines.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>
@endsection
