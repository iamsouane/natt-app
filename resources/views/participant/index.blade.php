@extends('layouts.app')

@section('title', 'Mes Tontines - NATT-APP')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-handshake text-primary mr-2"></i>Mes Tontines
        </h1>
        <div class="d-flex">
            <button class="btn btn-sm btn-primary shadow-sm mr-2" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-filter fa-sm text-white-50 mr-1"></i> Filtrer
            </button>
            <a href="{{ route('participant.index') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Nouvelle Participation
            </a>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="row mb-4">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle fa-2x mr-3"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1">Succès!</h5>
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1">Erreur!</h5>
                            <p class="mb-0">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tontines Actives</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $tontines->where('estActive', true)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Cotisations Totales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ auth()->user()->cotisations->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Progression Moyenne</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ round($tontines->avg('progression'), 1) }}%
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ round($tontines->avg('progression'), 1) }}%"
                                            aria-valuenow="{{ round($tontines->avg('progression'), 1) }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tontines Gérées</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $tontines->filter(function($tontine) { return $tontine->gerants->contains(auth()->id()); })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tontines List -->
    @if($tontines->isEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <img src="{{ asset('img/empty-state.svg') }}" alt="Aucune tontine" class="img-fluid mb-4" style="max-width: 300px;">
                <h4 class="text-gray-800 mb-3">Aucune tontine disponible</h4>
                <p class="text-muted mb-4">Vous ne participez à aucune tontine pour le moment.</p>
                <a href="{{ route('participant.index') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus mr-2"></i> Rejoindre une tontine
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($tontines as $tontine)
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-{{ $tontine->estActive ? 'success' : 'secondary' }} shadow-sm h-100">
                        <div class="card-header bg-white py-3 border-bottom-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('participant.cotisations.index', $tontine) }}" class="text-decoration-none">
                                    <h5 class="font-weight-bold text-{{ $tontine->estActive ? 'primary' : 'secondary' }} mb-0">
                                        <i class="fas fa-handshake mr-2"></i>{{ $tontine->libelle }}
                                    </h5>
                                </a>
                                <div>
                                    <span class="badge badge-pill badge-{{ $tontine->estActive ? 'success' : 'secondary' }}">
                                        {{ $tontine->estActive ? 'Active' : 'Terminée' }}
                                    </span>
                                    @if($tontine->gerants->contains(auth()->id()))
                                        <span class="badge badge-pill badge-warning ml-1">Gérant</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">{{ Str::limit($tontine->description, 120) }}</p>
                            
                            <div class="tontine-details mb-3">
                                <div class="detail-item mb-2">
                                    <i class="fas fa-money-bill-wave text-success mr-2"></i>
                                    <span>Montant: <strong>{{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</strong></span>
                                </div>
                                <div class="detail-item mb-2">
                                    <i class="fas fa-users text-info mr-2"></i>
                                    <span>Participants: <strong>{{ $tontine->participants->count() }}/{{ $tontine->nbre_participant }}</strong></span>
                                </div>
                                <div class="detail-item mb-2">
                                    <i class="fas fa-calendar-alt text-warning mr-2"></i>
                                    <span>Période: 
                                        <strong>{{ Carbon::parse($tontine->date_debut)->format('d/m/Y') }} - 
                                        {{ Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</strong>
                                    </span>
                                </div>
                                <div class="detail-item mb-3">
                                    <i class="fas fa-chart-pie text-primary mr-2"></i>
                                    <span>Progression: 
                                        <div class="progress mt-1" style="height: 8px;">
                                            <div class="progress-bar bg-primary" role="progressbar" 
                                                 style="width: {{ $tontine->progression }}%;" 
                                                 aria-valuenow="{{ $tontine->progression }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted float-right">{{ round($tontine->progression, 1) }}%</small>
                                    </span>
                                </div>
                                
                                @if($tontine->estActive)
                                <div class="detail-item">
                                    <i class="fas fa-clock text-danger mr-2"></i>
                                    <span>Prochaine cotisation: 
                                        <strong>
                                            @if($tontine->date_prochaine_cotisation)
                                                {{ $tontine->date_prochaine_cotisation->format('d/m/Y') }}
                                            @else
                                                Non définie
                                            @endif
                                        </strong>
                                    </span>
                                </div>
                                @endif
                            </div>

                            @if($tontine->images->isNotEmpty())
    <div class="tontine-images mb-3">
        <p class="small text-muted mb-1"><i class="fas fa-image mr-1"></i> Documents:</p>
        <div class="d-flex flex-wrap">
            @foreach ($tontine->images->take(3) as $image)
                @if(Storage::disk('public')->exists($image->chemin_image))
                    <a href="{{ asset('storage/'.$image->chemin_image) }}" 
                       data-fancybox="gallery-{{ $tontine->id }}" 
                       data-caption="{{ $tontine->libelle }}"
                       class="mr-2 mb-2">
                        <img src="{{ asset('storage/'.$image->chemin_image) }}"
                             alt="{{ $image->nom_image }}"
                             class="img-thumbnail"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    </a>
                @else
                    <div class="mr-2 mb-2 text-danger">
                        Image non trouvée: {{ $image->chemin_image }}
                    </div>
                @endif
            @endforeach
            @if($tontine->images->count() > 3)
                <a href="#" class="d-flex align-items-center justify-content-center mr-2 mb-2" 
                   style="width: 80px; height: 80px; background: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 4px;"
                   data-toggle="tooltip" title="Voir plus d'images">
                    <span class="text-muted">+{{ $tontine->images->count() - 3 }}</span>
                </a>
            @endif
        </div>
    </div>
@endif
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('participant.cotisations.index', $tontine) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                   <i class="fas fa-eye mr-1"></i> Détails
                                </a>
                                
                                @if($tontine->gerants->contains(auth()->id()))
                                    <form action="{{ route('participant.tontines.sendMailsGerant', $tontine->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <i class="fas fa-envelope mr-1"></i> Rappel
                                        </button>
                                    </form>
                                @endif
                                
                                @if($tontine->canCotiser())
                                    <a href="{{ route('participant.cotisations.create', $tontine->id) }}" 
                                       class="btn btn-sm btn-success">
                                       <i class="fas fa-coins mr-1"></i> Cotiser
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="filterModalLabel"><i class="fas fa-filter mr-2"></i>Filtrer les tontines</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('participant.index') }}" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Statut</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actives</option>
                            <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Terminées</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="frequency">Fréquence</label>
                        <select class="form-control" id="frequency" name="frequency">
                            <option value="">Toutes les fréquences</option>
                            <option value="JOURNALIERE" {{ request('frequency') == 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                            <option value="HEBDOMADAIRE" {{ request('frequency') == 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                            <option value="MENSUELLE" {{ request('frequency') == 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .card {
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        border-left-width: 4px;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .detail-item {
        display: flex;
        align-items: center;
        padding: 4px 0;
    }

    .progress {
        border-radius: 4px;
        background-color: #f8f9fa;
    }

    .alert-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .border-left-primary {
        border-left-color: #4e73df !important;
    }
    
    .border-left-success {
        border-left-color: #1cc88a !important;
    }
    
    .border-left-info {
        border-left-color: #36b9cc !important;
    }
    
    .border-left-warning {
        border-left-color: #f6c23e !important;
    }
    
    .border-left-secondary {
        border-left-color: #858796 !important;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }

        .tontine-images img {
            width: 60px !important;
            height: 60px !important;
        }
    }
</style>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize fancybox for image galleries
        Fancybox.bind("[data-fancybox]", {
            // Options
        });
    });
</script>
@endsection