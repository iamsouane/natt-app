@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tontines disponibles</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Montant de base</th>
                <th>Nombre de cotisations max</th>
                <th>Nombre de cotisations restantes</th> <!-- Nouvelle colonne -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tontines as $tontine)
            <tr>
                <td>{{ $tontine->libelle }}</td>
                <td>{{ number_format($tontine->montant_de_base, 2) }} FCFA</td>
                <td>{{ $tontine->nbre_cotisation }}</td>
                <td>{{ $tontine->cotisationsRestantes() }}</td> <!-- Affichage des cotisations restantes -->
                <td>
                    <a href="{{ route('participant.cotisations.create', $tontine->id) }}" class="btn btn-primary">
                        Cotiser
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection