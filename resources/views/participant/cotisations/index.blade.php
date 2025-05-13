@extends('layouts.app')

@section('title', 'Mes Cotisations - NATT-APP')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-wallet text-primary mr-2"></i>Mes Cotisations Disponibles
        </h1>
        <div class="d-flex">
            <a href="{{ route('participant.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Retour
            </a>
        </div>
    </div>

    <!-- Alerts Section -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x mr-3"></i>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
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

    <!-- Cotisations Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary font-weight-bold">
                    <i class="fas fa-list-ul mr-2"></i>Liste des Tontines
                </h5>
                <span class="badge badge-primary">
                    {{ $tontines->count() }} tontine(s) disponible(s)
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-left pl-4">Tontine</th>
                            <th class="text-center">Montant</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Prochaine Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tontines as $tontine)
                            @php 
                                $restantes = $tontine->cotisationsRestantesPourParticipant(Auth::id());
                                $prochaineDate = $tontine->getDateProchaineCotisationAttribute();
                            @endphp
                            <tr>
                                <td class="align-middle pl-4">
                                    <div class="d-flex align-items-center">
                                        @if($tontine->images->isNotEmpty())
                                            <img src="{{ asset('storage/tontines/' . $tontine->images->first()->nom_image) }}" 
                                                 class="rounded-circle mr-3" 
                                                 width="40" 
                                                 height="40" 
                                                 alt="{{ $tontine->libelle }}"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-handshake text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $tontine->libelle }}</h6>
                                            <small class="text-muted">{{ $tontine->frequence }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="font-weight-bold text-success">
                                        {{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    @if($restantes == 0)
                                        <span class="badge badge-pill badge-danger px-3 py-1">Complète</span>
                                    @else
                                        <span class="badge badge-pill badge-success px-3 py-1">
                                            {{ $restantes }} restante(s)
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if($prochaineDate)
                                        <span class="text-primary font-weight-bold">
                                            {{ $prochaineDate->format('d/m/Y') }}
                                        </span>
                                        <small class="d-block text-muted">
                                            {{ $prochaineDate->diffForHumans() }}
                                        </small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('participant.cotisations.create', $tontine->id) }}" 
                                           class="btn btn-sm btn-primary mr-2 {{ $restantes == 0 ? 'disabled' : '' }}"
                                           data-toggle="tooltip" 
                                           title="Effectuer une cotisation">
                                            <i class="fas fa-coins mr-1"></i> Cotiser
                                        </a>
                                        <a href="{{ route('participant.historique') }}" 
                                           class="btn btn-sm btn-outline-secondary"
                                           data-toggle="tooltip" 
                                           title="Voir l'historique">
                                            <i class="fas fa-history"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="text-center py-5">
                                        <img src="{{ asset('img/no-data.svg') }}" alt="Aucune donnée" class="img-fluid mb-4" style="max-width: 200px;">
                                        <h5 class="text-gray-800">Aucune tontine disponible</h5>
                                        <p class="text-muted">Vous ne participez à aucune tontine pour le moment.</p>
                                        <a href="{{ route('participant.index') }}" class="btn btn-primary px-4">
                                            <i class="fas fa-handshake mr-2"></i> Rejoindre une tontine
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($tontines->isNotEmpty())
            <div class="card-footer bg-white border-top-0">
                <div class="text-muted small">
                    Affichage de <strong>{{ $tontines->count() }}</strong> tontines
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Card Styling */
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    /* Table Styling */
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        border-top: 0;
        border-bottom: 1px solid #e3e6f0;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #4e73df;
        vertical-align: middle;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.03);
    }
    
    /* Badge Styling */
    .badge-pill {
        border-radius: 10rem;
    }
    
    /* Button Styling */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }
        
        .table thead {
            display: none;
        }
        
        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }
        
        .table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 1rem;
            color: #4e73df;
        }
        
        .table tbody td:last-child {
            border-bottom: 0;
        }
        
        .d-flex.justify-content-center {
            justify-content: flex-end !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Add data-label attributes for responsive tables
    document.addEventListener('DOMContentLoaded', function() {
        const headers = document.querySelectorAll('.table thead th');
        const rows = document.querySelectorAll('.table tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (headers[index]) {
                    cell.setAttribute('data-label', headers[index].textContent.trim());
                }
            });
        });
    });
</script>
@endsection