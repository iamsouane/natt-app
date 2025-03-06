@extends('layouts.app')

@section('content')
    <h1>Créer une Tontine</h1>
    <form action="{{ route('tontines.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="frequence">Fréquence</label>
            <select name="frequence" id="frequence" class="form-control" required>
                <option value="JOURNALIERE">Journalière</option>
                <option value="HEBDOMADAIRE">Hebdomadaire</option>
                <option value="MENSUELLE">Mensuelle</option>
            </select>
        </div>
        <div class="form-group">
            <label for="libelle">Libellé</label>
            <input type="text" name="libelle" id="libelle" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date_debut">Date de début</label>
            <input type="date" name="date_debut" id="date_debut" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date_fin">Date de fin</label>
            <input type="date" name="date_fin" id="date_fin" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="montant_total">Montant total</label>
            <input type="number" name="montant_total" id="montant_total" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="montant_de_base">Montant de base</label>
            <input type="number" name="montant_de_base" id="montant_de_base" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nbre_participant">Nombre de participants</label>
            <input type="number" name="nbre_participant" id="nbre_participant" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection