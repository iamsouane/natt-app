@extends('layouts.app')

@section('title', 'Historique des Cotisations - NATT-APP')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-history text-primary mr-2"></i>Historique des Cotisations
        </h1>
        <div class="d-flex">
            <a href="{{ route('participant.cotisations.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Retour
            </a>
        </div>
    </div>

    <!-- Calcul des totaux -->
    @php
        // Total des montants partiels
        $totalPartiel = 0;
        // Nombre de tirages gagnés (en utilisant la relation avec le modèle Tirage)
        $tiragesGagnes = Auth::user()->tirages->count();
        
        foreach($cotisations as $cotisation) {
            $totalPartiel += $montantsPartiels[$cotisation->id_tontine] ?? 0;
        }
    @endphp

    <!-- Summary Cards with Hover Effects -->
    <div class="row mb-4">
        <!-- Carte Tontines Actives -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-2 hover-scale">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tontines Actives</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $tontinesParticipees }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Total Cotisé -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-2 hover-scale">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Cotisé</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalPartiel, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Nombre de Cotisations -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-left-info shadow-sm h-100 py-2 hover-scale">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Cotisations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $cotisations->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-ul fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Tirages Gagnés -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-2 hover-scale">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Tirages Gagnés</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $tiragesGagnes }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cotisations Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary font-weight-bold">
                    <i class="fas fa-receipt mr-2"></i>Détail des Cotisations
                </h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                            id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter mr-1"></i>Filtrer
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="#">Toutes</a>
                        <a class="dropdown-item" href="#">Ce mois</a>
                        <a class="dropdown-item" href="#">Cette année</a>
                        <div class="dropdown-divider"></div>
                        @foreach($cotisations->pluck('tontine')->unique('id') as $tontine)
                            <a class="dropdown-item" href="#">{{ $tontine->libelle }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="pl-4">Tontine</th>
                            <th class="text-center">Séance</th>
                            <th class="text-center">Montant</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Résultat Tirage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotisations as $cotisation)
                            @php
                                // Vérifie si cette cotisation est associée à un tirage gagné
                                $estGagnant = Auth::user()->tirages()
                                    ->where('id_tontine', $cotisation->id_tontine)
                                    ->where('numero_seance', $cotisation->numero_seance)
                                    ->exists();
                            @endphp
                            <tr>
                                <td class="pl-4">
                                    <div class="d-flex align-items-center">
                                        @if($cotisation->tontine->images->isNotEmpty())
                                            <img src="{{ asset('storage/tontines/' . $cotisation->tontine->images->first()->nom_image) }}" 
                                                 class="rounded-circle mr-3" 
                                                 width="40" 
                                                 height="40" 
                                                 alt="{{ $cotisation->tontine->libelle }}"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-handshake text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $cotisation->tontine->libelle ?? 'N/A' }}</h6>
                                            <small class="text-muted">{{ $cotisation->tontine->frequence ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-pill badge-primary px-3">
                                        #{{ $cotisation->numero_seance }}
                                    </span>
                                </td>
                                <td class="text-center align-middle font-weight-bold text-success">
                                    {{ number_format($montantsPartiels[$cotisation->id_tontine] ?? 0, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="text-center align-middle">
                                    <div>{{ \Carbon\Carbon::parse($cotisation->date_cotisation)->format('d/m/Y') }}</div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($cotisation->date_cotisation)->diffForHumans() }}
                                    </small>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge badge-pill badge-success px-3">Validée</span>
                                </td>
                                <td class="text-center align-middle">
                                    @if($estGagnant)
                                        <span class="badge badge-pill badge-warning px-3">
                                            <i class="fas fa-trophy mr-1"></i> Gagnant
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-secondary px-3">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="text-center py-5">
                                        <img src="{{ asset('img/no-data.svg') }}" alt="Aucune donnée" class="img-fluid mb-4" style="max-width: 200px;">
                                        <h5 class="text-gray-800">Aucune cotisation enregistrée</h5>
                                        <p class="text-muted">Vous n'avez effectué aucune cotisation pour le moment.</p>
                                        <a href="{{ route('participant.cotisations.index') }}" class="btn btn-primary px-4">
                                            <i class="fas fa-wallet mr-2"></i> Effectuer une cotisation
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($cotisations->count() > 0)
            <div class="card-footer bg-white border-top-0">
                <div class="text-muted small">
                    Affichage de <strong>{{ $cotisations->count() }}</strong> cotisations
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
        transition: all 0.3s ease;
    }
    
    /* Hover Effects */
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Border Colors */
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 4px solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
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