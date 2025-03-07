@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Participer à la Tontine : {{ $tontine->libelle }}</h1>
        <form action="{{ route('participant.cotisations.store', $tontine) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="montant">Montant</label>
                <input type="number" name="montant" id="montant" class="form-control" value="{{ $tontine->montant_de_base }}" required>
            </div>
            <div class="form-group">
                <label for="moyen_paiement">Moyen de paiement</label>
                <select name="moyen_paiement" id="moyen_paiement" class="form-control" required>
                    <option value="ESPECES">Espèces</option>
                    <option value="WAVE">Wave</option>
                    <option value="OM">Orange Money</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
@endsection