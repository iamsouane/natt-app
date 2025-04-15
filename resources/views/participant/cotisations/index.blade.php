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
                <th>Nombre de cotisations restantes</th> 
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tontines as $tontine)
            <tr>
                <td>{{ $tontine->libelle }}</td>
                <td>{{ number_format($tontine->montant_de_base, 2) }} FCFA</td>
                <td>{{ $tontine->nbre_cotisation }}</td>
                <td>
                    @if($tontine->cotisationsRestantesPourParticipant(Auth::id()) == 0)
                        <span class="badge badge-danger">Complète</span>
                    @else
                        {{ $tontine->cotisationsRestantesPourParticipant(Auth::id()) }}
                    @endif
                </td>
                <td>
                    @if($tontine->cotisationsRestantesPourParticipant(Auth::id()) > 0)
                        <a href="{{ route('participant.cotisations.create', $tontine->id) }}" class="btn btn-primary">
                            Cotiser
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled>Complet</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection