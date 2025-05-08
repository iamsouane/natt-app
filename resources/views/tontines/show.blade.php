@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Affichage des messages flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <h1 class="mb-4 text-center text-primary fw-bold">Détails de la Tontine</h1>

    <!-- Illustration SVG -->
    <div class="text-center mb-4">
        <svg width="80" height="80" fill="#0d6efd" viewBox="0 0 24 24">
            <path d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z"/>
            <path d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z"/>
        </svg>
    </div>

    <div class="card shadow rounded-4 p-4 bg-light">
        <div class="row">
            <div class="col-md-6 mb-3">
                <h4 class="text-primary">{{ $tontine->libelle }}</h4>
                <ul class="list-unstyled">
                    <li><strong>Fréquence :</strong> {{ ucfirst(strtolower($tontine->frequence)) }}</li>
                    <li><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</li>
                    <li><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</li>
                    <li><strong>Description :</strong><br><span class="text-muted">{{ $tontine->description }}</span></li>
                </ul>
            </div>

            <div class="col-md-6 mb-3">
                <ul class="list-unstyled">
                    <li><strong>Montant total :</strong> <span class="badge bg-success fs-6">{{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA</span></li>
                    <li><strong>Montant de base :</strong> <span class="badge bg-info text-dark fs-6">{{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</span></li>
                    <li><strong>Participants :</strong> {{ $tontine->nbre_participant }}</li>
                    <li><strong>Cotisations :</strong> {{ $tontine->nbre_cotisation }}</li>
                </ul>
            </div>
        </div>

        <!-- Images -->
        <div class="mt-4">
            <strong>Images associées :</strong>
            <div class="d-flex flex-wrap mt-2">
                @forelse ($tontine->images as $image)
                    <img src="{{ asset('storage/tontines/' . $image->nom_image) }}"
                         alt="{{ $image->nom_image }}"
                         class="rounded shadow-sm m-2"
                         style="width: 120px; height: auto; cursor: pointer;"
                         data-bs-toggle="modal"
                         data-bs-target="#imageModal"
                         onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                @empty
                    <p class="text-muted">Aucune image disponible.</p>
                @endforelse
            </div>
        </div>

        <!-- Promotion -->
        <div class="mt-5">
            <h5 class="text-primary">Promouvoir un participant en tant que gérant</h5>
            <form method="POST" action="{{ route('tontines.promouvoir', $tontine) }}" class="row g-3 mt-3">
                @csrf
                <div class="col-md-8">
                    <select name="user_id" class="form-select rounded-pill shadow-sm" required>
                        <option value="">-- Sélectionner un participant --</option>
                        @foreach($tontine->participantsActifs() as $participant)
                            <option value="{{ $participant->id }}">{{ $participant->name }} ({{ $participant->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                        <i class="bi bi-person-plus-fill me-1"></i> Promouvoir
                    </button>
                </div>
            </form>
        </div>

        <!-- Actions -->
        <div class="mt-5 d-flex flex-wrap justify-content-between">
            <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning rounded-pill shadow-sm mb-2">
                <i class="bi bi-pencil-square me-1"></i> Modifier
            </a>

            <form action="{{ route('tontines.destroy', $tontine) }}" method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tontine ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger rounded-pill shadow-sm">
                    <i class="bi bi-trash3-fill me-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('tontines.index') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-arrow-left-circle me-1"></i> Retour à la liste
        </a>
    </div>
</div>

<!-- Modale Bootstrap -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title">Aperçu de l'image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Image de la tontine" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@endsection