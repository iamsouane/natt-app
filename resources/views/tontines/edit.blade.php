@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier la Tontine : {{ $tontine->libelle }}</h1>

        <form action="{{ route('tontines.update', $tontine) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="libelle">Libellé</label>
                <input type="text" class="form-control" id="libelle" name="libelle" value="{{ old('libelle', $tontine->libelle) }}" required>
            </div>

            <div class="form-group">
                <label for="frequence">Fréquence</label>
                <select class="form-control" id="frequence" name="frequence" required>
                    <option value="JOURNALIERE" {{ old('frequence', $tontine->frequence) == 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                    <option value="HEBDOMADAIRE" {{ old('frequence', $tontine->frequence) == 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                    <option value="MENSUELLE" {{ old('frequence', $tontine->frequence) == 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ old('date_debut', $tontine->date_debut) }}" required>
            </div>

            <div class="form-group">
                <label for="date_fin">Date de fin</label>
                <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ old('date_fin', $tontine->date_fin) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $tontine->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="montant_total">Montant total</label>
                <input type="number" class="form-control" id="montant_total" name="montant_total" value="{{ old('montant_total', $tontine->montant_total) }}" required min="1">
            </div>

            <div class="form-group">
                <label for="montant_de_base">Montant de base</label>
                <input type="number" class="form-control" id="montant_de_base" name="montant_de_base" value="{{ old('montant_de_base', $tontine->montant_de_base) }}" required min="1">
            </div>

            <div class="form-group">
                <label for="nbre_participant">Nombre de participants</label>
                <input type="number" class="form-control" id="nbre_participant" name="nbre_participant" value="{{ old('nbre_participant', $tontine->nbre_participant) }}" required min="1">
            </div>

            <div class="form-group">
                <label for="images">Images (optionnelles)</label>
                <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                @if ($tontine->images->count())
                    <p>Images actuelles :</p>
                    <div class="row">
                        @foreach ($tontine->images as $image)
                            <div class="col-md-3">
                                <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" class="img-fluid" style="height: 100px; margin-bottom: 10px;" data-toggle="modal" data-target="#imageModal" onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-warning">Mettre à jour</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Retour</a>
        </form>

        <!-- Modale pour afficher l'image -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Image" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection