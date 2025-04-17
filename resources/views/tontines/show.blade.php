@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Détails de la Tontine</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $tontine->libelle }}</h5>
                <p class="card-text"><strong>Fréquence :</strong> {{ ucfirst(strtolower($tontine->frequence)) }}</p>
                <p class="card-text"><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</p>
                <p class="card-text"><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</p>
                <p class="card-text"><strong>Description :</strong> {{ $tontine->description }}</p>
                <p class="card-text"><strong>Montant total :</strong> {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</p>
                <p class="card-text"><strong>Montant de base :</strong> {{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</p>
                <p class="card-text"><strong>Nombre de participants :</strong> {{ $tontine->nbre_participant }}</p>
                <p class="card-text"><strong>Nombre de cotisations :</strong> {{ $tontine->nbre_cotisation }}</p>

                <!-- Affichage des images -->
                <div class="mt-3">
                    <strong>Image de la tontine</strong><br>
                    @foreach ($tontine->images as $image)
                        <img src="{{ asset('storage/tontines/' . $image->nom_image) }}"
                             alt="{{ $image->nom_image }}"
                             style="width: 120px; height: auto; margin: 5px; cursor: pointer;"
                             data-toggle="modal"
                             data-target="#imageModal"
                             onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                    @endforeach
                </div>

                <div class="mt-4">
                    <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning">Modifier</a>

                    <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tontine ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>

        <a href="{{ route('tontines.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>

    <!-- Modale Bootstrap pour l'aperçu de l'image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Image" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
@endsection