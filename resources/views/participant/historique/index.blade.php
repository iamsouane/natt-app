@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mon historique</h2>

    {{-- Tontines --}}
    <h4 class="mt-4">Tontines auxquelles je participe</h4>
    @if($tontines->count())
        <ul class="list-group">
            @foreach($tontines as $tontine)
                <li class="list-group-item">
                    {{ $tontine->libelle }} – {{ $tontine->description ?? 'Pas de description' }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucune tontine enregistrée.</p>
    @endif

    {{-- Cotisations --}}
    <h4 class="mt-4">Mes cotisations</h4>
    @if($cotisations->count())
        <ul class="list-group">
            @foreach($cotisations as $cotisation)
                <li class="list-group-item">
                    {{ $cotisation->montant }} FCFA le {{ $cotisation->created_at->format('d/m/Y') }}
                    @if($cotisation->tontine)
                        – Tontine : {{ $cotisation->tontine->libelle }}
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucune cotisation enregistrée.</p>
    @endif

    {{-- Tirages --}}
    <h4 class="mt-4">Tirages gagnés</h4>
    @if($tirages->count())
        <ul class="list-group">
            @foreach($tirages as $tirage)
                <li class="list-group-item">
                    Gagné le {{ $tirage->created_at->format('d/m/Y') }}
                    @if($tirage->tontine)
                        – Tontine : {{ $tirage->tontine->libelle }}
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun tirage gagné.</p>
    @endif
</div>
@endsection