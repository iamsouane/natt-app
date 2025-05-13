@extends('layouts.app')

@section('title', 'Détails de la Tontine')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <svg width="30" height="30" fill="currentColor" class="me-2" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
            </svg>
            Détails de la Tontine
        </h1>
        <a href="{{ route('tontines.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Messages flash -->
        @if(session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="emoji">🎉</span>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="emoji">⚠️</span>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Détails de la tontine -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">{{ $tontine->libelle }}</h6>
                    <span class="badge badge-light">
                        <i class="fas fa-calendar-alt fa-sm text-primary mr-1"></i>
                        {{ ucfirst(strtolower($tontine->frequence)) }}
                    </span>
                </div>
                
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <!-- Colonne gauche -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-info-circle mr-2"></i>Informations
                                </h5>
                                <div class="pl-4">
                                    <p><strong>Date de début:</strong> {{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</p>
                                    <p><strong>Date de fin:</strong> {{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</p>
                                    <p><strong>Description:</strong><br>
                                    <span class="text-muted">{{ $tontine->description ?? 'Aucune description' }}</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Colonne droite -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-chart-pie mr-2"></i>Statistiques
                            </h5>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Montant total</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="emoji">💰</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Montant de base</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="emoji">💵</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Participants</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $tontine->nbre_participant }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="emoji">👥</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Cotisations</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $tontine->nbre_cotisation }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <span class="emoji">📊</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Galerie d'images -->
                    <div class="mt-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-images mr-2"></i>Galerie
                        </h5>
                        @if($tontine->images->count() > 0)
                            <div class="row">
                                @foreach ($tontine->images as $image)
                                    <div class="col-md-3 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" 
                                                 class="card-img-top img-fluid cursor-pointer"
                                                 style="height: 150px; object-fit: cover;"
                                                 data-toggle="modal"
                                                 data-target="#imageModal"
                                                 onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                                            <div class="card-body py-2">
                                                <p class="card-text text-center small text-muted">
                                                    {{ Str::limit($image->nom_image, 20) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune image disponible pour cette tontine</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Promotion de gérant -->
                    <div class="mt-5">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-user-cog mr-2"></i>Gestion des droits
                        </h5>
                        <div class="card shadow">
                            <div class="card-body">
                                <form method="POST" action="{{ route('tontines.promouvoir', $tontine) }}">
                                    @csrf
                                    <div class="form-row align-items-center">
                                        <div class="col-md-8 mb-2">
                                            <label class="sr-only">Promouvoir un participant</label>
                                            <select name="user_id" class="form-control" required>
                                                <option value="">-- Sélectionner un participant --</option>
                                                @foreach($tontine->participantsActifs() as $participant)
                                                    <option value="{{ $participant->id }}">{{ $participant->prenom }} {{ $participant->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <span class="emoji mr-1">👑</span> Promouvoir
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-5 pt-3 border-top">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning">
                                <i class="fas fa-edit mr-1"></i> Modifier
                            </a>
                            
                            <form action="{{ route('tontines.destroy', $tontine) }}" method="POST"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tontine ? Toutes les données associées seront perdues.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modale d'image -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fas fa-image mr-2"></i>Image de la tontine
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <img id="modalImage" src="" class="img-fluid w-100" alt="Image agrandie">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .emoji {
        font-size: 1.5rem;
        vertical-align: middle;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .card-img-top {
        transition: transform 0.3s ease;
    }
    .card-img-top:hover {
        transform: scale(1.02);
    }
</style>

<script>
    // Animation des éléments avec AOS
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    });
</script>
@endsection