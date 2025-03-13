@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Faire une cotisation pour {{ $tontine->libelle }}</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('participant.cotisations.store', $tontine->id) }}" method="POST">
        @csrf

        <!-- Champ Montant (Calculé automatiquement) -->
        <div class="mb-3">
            <label for="montant" class="form-label">Montant à cotiser</label>
            <input type="text" name="montant" class="form-control" value="{{ number_format($montant_partiel, 2) }} FCFA" readonly>
        </div>

        <!-- Champ Moyen de Paiement -->
        <div class="mb-3">
            <label for="moyen_paiement" class="form-label">Moyen de paiement</label>
            <select name="moyen_paiement" class="form-control" required>
                <option value="ESPECES">Espèces</option>
                <option value="WAVE">Wave</option>
                <option value="OM">Orange Money</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cotiser</button>
        <a href="{{ route('participant.cotisations.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection