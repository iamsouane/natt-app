@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Détails de la cotisation</h2>
    <p><strong>Montant :</strong> {{ number_format($cotisation->montant, 2) }} FCFA</p>
    <p><strong>Moyen de paiement :</strong> {{ $cotisation->moyen_paiement }}</p>
    <a href="{{ route('participant.cotisations.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection