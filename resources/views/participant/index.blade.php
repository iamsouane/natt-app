@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tontines disponibles</h2>

    @if($tontines->isEmpty())
        <div class="alert alert-info">Aucune tontine disponible pour le moment.</div>
    @else
        <div class="row">
            @foreach($tontines as $tontine)
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <!-- Lien autour du nom de la tontine -->
                            <h5 class="mb-0">
                                <a href="{{ route('participant.cotisations.index', $tontine) }}" class="text-decoration-none text-white">
                                    {{ $tontine->libelle }}
                                </a>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Description :</strong> {{ $tontine->description }}</p>
                            <p><strong>Montant :</strong> {{ $tontine->montant_de_base }} FCFA</p>
                            <p><strong>Participants :</strong> {{ $tontine->nbre_participant }}</p>
                            <p><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</p>
                            <p><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</p>
                            
                            @if($tontine->images->isNotEmpty())
                                <div class="mt-3">
                                    <strong>Image :</strong><br>
                                    @foreach ($tontine->images as $image)
                                        <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" 
                                             alt="{{ $image->nom_image }}" 
                                             style="width: 100px; height: auto; margin-bottom: 5px; cursor: pointer;" 
                                             data-toggle="modal" 
                                             data-target="#imageModal" 
                                             onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modale Bootstrap pour affichage de l’image -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aperçu de l'image</h5>
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
@endsection