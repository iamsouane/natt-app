@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Modifier la Tontine</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('tontines.update', $tontine) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="frequence" class="form-label">Fréquence</label>
                        <select name="frequence" id="frequence" class="form-control" required>
                            <option value="JOURNALIERE" {{ $tontine->frequence === 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                            <option value="HEBDOMADAIRE" {{ $tontine->frequence === 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                            <option value="MENSUELLE" {{ $tontine->frequence === 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="libelle" class="form-label">Libellé</label>
                        <input type="text" name="libelle" id="libelle" class="form-control" value="{{ old('libelle', $tontine->libelle) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control"
                                   value="{{ old('date_debut', \Carbon\Carbon::parse($tontine->date_debut)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" name="date_fin" id="date_fin" class="form-control"
                                   value="{{ old('date_fin', \Carbon\Carbon::parse($tontine->date_fin)->format('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" required>{{ old('description', $tontine->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="montant_total" class="form-label">Montant total</label>
                            <input type="number" name="montant_total" id="montant_total" class="form-control"
                                   value="{{ old('montant_total', $tontine->montant_total) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="montant_de_base" class="form-label">Montant de base</label>
                            <input type="number" name="montant_de_base" id="montant_de_base" class="form-control"
                                   value="{{ old('montant_de_base', $tontine->montant_de_base) }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nbre_participant" class="form-label">Nombre de participants</label>
                        <input type="number" name="nbre_participant" id="nbre_participant" class="form-control"
                               value="{{ old('nbre_participant', $tontine->nbre_participant) }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection