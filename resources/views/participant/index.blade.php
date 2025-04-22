@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center font-weight-bold">🎯 Tontines disponibles</h2>

    @if($tontines->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Aucune tontine disponible pour le moment.
        </div>
    @else
        <div class="row">
            @foreach($tontines as $tontine)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-lg h-100">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <a href="{{ route('participant.cotisations.index', $tontine) }}" class="text-white text-decoration-none">
                                    <i class="fas fa-handshake mr-2"></i>{{ $tontine->libelle }}
                                </a>
                            </h5>
                        </div>
                        <div class="card-body">
                            <p><strong><i class="fas fa-align-left mr-1"></i>Description :</strong> {{ $tontine->description }}</p>
                            <p><strong><i class="fas fa-money-bill-wave mr-1"></i>Montant :</strong> 
                                <span class="badge badge-success">{{ $tontine->montant_de_base }} FCFA</span></p>
                            <p><strong><i class="fas fa-users mr-1"></i>Participants :</strong> {{ $tontine->nbre_participant }}</p>
                            <p><strong><i class="fas fa-calendar-alt mr-1"></i>Date de début :</strong> 
                                {{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</p>
                            <p><strong><i class="fas fa-calendar-check mr-1"></i>Date de fin :</strong> 
                                {{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</p>

                            @if($tontine->images->isNotEmpty())
                                <div class="mt-3">
                                    <strong><i class="fas fa-image mr-1"></i>Image :</strong><br>
                                    @foreach ($tontine->images as $image)
                                        <img src="{{ asset('storage/tontines/' . $image->nom_image) }}"
                                             alt="{{ $image->nom_image }}"
                                             class="img-thumbnail mr-2 mb-2"
                                             style="width: 100px; height: auto; cursor: pointer;"
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
                <img id="modalImage" src="" alt="Image" class="img-fluid rounded shadow-sm" />
            </div>
        </div>
    </div>
</div>
@endsection