@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Effectuer un Tirage</h2>

    <p><strong>Tontine :</strong> {{ $tontine->libelle }}</p>
    <p><strong>Séance :</strong> {{ $seance }}</p>

    <form action="{{ route('tirages.effectuer', ['tontine' => $tontine->id, 'seance' => $seance]) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Lancer le Tirage</button>
    </form>

    @if (session('gagnant'))
        <div class="alert alert-success mt-3">
            🎉 Félicitations à <strong>{{ session('gagnant') }}</strong> qui a remporté cette séance !
        </div>
    @endif

</div>
@endsection
