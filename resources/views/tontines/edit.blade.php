@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier la Tontine</h1>
        <form action="{{ route('tontines.update', $tontine) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="frequence">Fréquence</label>
                <select name="frequence" id="frequence" class="form-control" required>
                    <option value="JOURNALIERE" {{ $tontine->frequence === 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                    <option value="HEBDOMADAIRE" {{ $tontine->frequence === 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                    <option value="MENSUELLE" {{ $tontine->frequence === 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                </select>
            </div>
            <div class="form-group">
                <label for="libelle">Libellé</label>
                <input type="text" name="libelle" id="libelle" class="form-control" value="{{ $tontine->libelle }}" required>
            </div>
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ $tontine->date_debut }}" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ $tontine->date_fin }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ $tontine->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="montant_total">Montant total</label>
                <input type="number" name="montant_total" id="montant_total" class="form-control" value="{{ $tontine->montant_total }}" required>
            </div>
            <div class="form-group">
                <label for="montant_de_base">Montant de base</label>
                <input type="number" name="montant_de_base" id="montant_de_base" class="form-control" value="{{ $tontine->montant_de_base }}" required>
            </div>
            <div class="form-group">
                <label for="nbre_participant">Nombre de participants</label>
                <input type="number" name="nbre_participant" id="nbre_participant" class="form-control" value="{{ $tontine->nbre_participant }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection