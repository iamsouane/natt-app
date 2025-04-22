@extends('layouts.app')

@section('content')
<div class="container my-5">
    {{-- 🌟 Illustration en haut --}}
    <div class="text-center mb-5">
        <div class="text-center mb-4">
            {{-- SVG intégré directement --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="140" height="140" fill="currentColor" class="bi bi-clock-history mb-3 text-primary" viewBox="0 0 16 16">
                <path d="M8.515 3.879a.5.5 0 0 1 .485.621l-.347 1.392a.5.5 0 0 1-.97-.242l.347-1.392a.5.5 0 0 1 .485-.379zm-2.03 0a.5.5 0 0 0-.485.621l.347 1.392a.5.5 0 1 0 .97-.242l-.347-1.392a.5.5 0 0 0-.485-.379z"/>
                <path d="M8 1a7 7 0 1 0 4.546 12.31.5.5 0 0 0-.635-.772A6 6 0 1 1 14 8a.5.5 0 0 0 1 0A7 7 0 0 0 8 1z"/>
                <path d="M7.5 8V5a.5.5 0 0 1 1 0v2.707l2.146 2.147a.5.5 0 0 1-.708.708L7.5 8.707z"/>
            </svg>
            <h2 class="font-weight-bold">Mon Historique</h2>
            <p class="text-muted">Suivez vos tontines, cotisations et tirages gagnés</p>
        </div>
    </div>

    {{-- 🎯 Tontines --}}
    <div class="mb-5 animated fadeInUp">
        <h4 class="text-primary">📌 Tontines auxquelles je participe</h4>
        @if($tontines->count())
            <ul class="list-group shadow-sm rounded">
                @foreach($tontines as $tontine)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $tontine->libelle }}</strong><br>
                            <small class="text-muted">{{ $tontine->description ?? 'Pas de description' }}</small>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-secondary mt-2">Aucune tontine enregistrée.</div>
        @endif
    </div>

    {{-- 💰 Cotisations --}}
    <div class="mb-5 animated fadeInUp delay-1s">
        <h4 class="text-success">💰 Mes cotisations</h4>
        @if($cotisations->count())
            <ul class="list-group shadow-sm rounded">
                @foreach($cotisations as $cotisation)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $cotisation->montant }} FCFA 
                        <span class="text-muted small">
                            ({{ $cotisation->created_at->format('d/m/Y') }}) 
                            – {{ $cotisation->tontine->libelle ?? '' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-secondary mt-2">Aucune cotisation enregistrée.</div>
        @endif
    </div>

    {{-- 🎉 Tirages --}}
    <div class="mb-5 animated fadeInUp delay-2s">
        <h4 class="text-warning">🎉 Tirages gagnés</h4>
        @if($tirages->count())
            <ul class="list-group shadow-sm rounded">
                @foreach($tirages as $tirage)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Gagné le {{ $tirage->created_at->format('d/m/Y') }}
                        <span class="text-muted small">
                            – {{ $tirage->tontine->libelle ?? '' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-secondary mt-2">Aucun tirage gagné.</div>
        @endif
    </div>
</div>
@endsection