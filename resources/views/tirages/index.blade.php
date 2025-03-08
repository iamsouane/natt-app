@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Liste des Tirages</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <h3>Tirages effectués</h3>
            @foreach($tirages as $tirage)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Tontine: {{ $tirage->tontine->libelle }}</h5>
                        <p class="card-text">Gagnant: <strong>{{ $tirage->user->name }}</strong></p>
                        <a href="{{ route('tirages.show', $tirage->id) }}" class="btn btn-info">Voir Détails</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
