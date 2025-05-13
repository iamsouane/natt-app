@extends('layouts.app')

@section('title', 'Mon Historique - NATT-APP')

@section('content')
<div class="container-fluid py-4">
    <!-- Header avec image de fond -->
    <div class="history-header bg-gradient-primary rounded-lg shadow mb-5" data-aos="fade-down">
        <div class="container py-5 text-center text-white">
            <div class="icon-circle bg-white text-primary mx-auto mb-4">
                <i class="fas fa-history fa-2x"></i>
            </div>
            <h1 class="h2 mb-2 font-weight-bold">Mon Historique Complet</h1>
            <p class="mb-0">Retracez toutes vos activités dans les tontines</p>
        </div>
    </div>

    <!-- Cartes statistiques animées -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-md-4 mb-4">
            <div class="card stat-card h-100 hover-scale" data-stat="tontines">
                <div class="card-body text-center py-4">
                    <div class="stat-icon bg-primary-light mb-3">
                        <i class="fas fa-handshake text-primary"></i>
                    </div>
                    <h3 class="font-weight-bold mb-1 counter" data-target="{{ $tontines->count() }}">0</h3>
                    <p class="text-muted mb-0">Tontines Actives</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card stat-card h-100 hover-scale" data-stat="cotisations">
                <div class="card-body text-center py-4">
                    <div class="stat-icon bg-success-light mb-3">
                        <i class="fas fa-coins text-success"></i>
                    </div>
                    <h3 class="font-weight-bold mb-1">
                        <span class="counter" data-target="{{ $cotisations->sum('montant') }}">0</span> FCFA
                    </h3>
                    <p class="text-muted mb-0">Total Cotisé</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card stat-card h-100 hover-scale" data-stat="tirages">
                <div class="card-body text-center py-4">
                    <div class="stat-icon bg-warning-light mb-3">
                        <i class="fas fa-trophy text-warning"></i>
                    </div>
                    <h3 class="font-weight-bold mb-1 counter" data-target="{{ $tirages->count() }}">0</h3>
                    <p class="text-muted mb-0">Tirages Gagnés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tontines avec onglets -->
    <div class="card shadow-lg mb-5 border-0" data-aos="fade-up">
        <div class="card-header bg-white py-3 border-bottom-0">
            <ul class="nav nav-tabs card-header-tabs" id="historyTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tontines-tab" data-toggle="tab" href="#tontines" role="tab">
                        <i class="fas fa-handshake mr-2"></i>Mes Tontines
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cotisations-tab" data-toggle="tab" href="#cotisations" role="tab">
                        <i class="fas fa-coins mr-2"></i>Cotisations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tirages-tab" data-toggle="tab" href="#tirages" role="tab">
                        <i class="fas fa-trophy mr-2"></i>Tirages
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-0">
            <div class="tab-content" id="historyTabsContent">
                <!-- Onglet Tontines -->
                <div class="tab-pane fade show active" id="tontines" role="tabpanel">
                    @if($tontines->count())
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Tontine</th>
                                        <th class="text-center">Progression</th>
                                        <th class="text-center">Montant</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tontines as $tontine)
                                        @php
                                            $userCotisations = $tontine->cotisations()->where('id_user', auth()->id())->count();
                                            $totalCotisations = $tontine->nbre_cotisation;
                                            $progressPercent = $totalCotisations > 0 ? round(($userCotisations/$totalCotisations)*100) : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($tontine->images->isNotEmpty())
                                                        <img src="{{ asset('storage/tontines/' . $tontine->images->first()->nom_image) }}" 
                                                             class="rounded-circle mr-3 shadow-sm" 
                                                             width="48" 
                                                             height="48" 
                                                             alt="{{ $tontine->libelle }}">
                                                    @endif
                                                    <div>
                                                        <h6 class="font-weight-bold mb-0">{{ $tontine->libelle }}</h6>
                                                        <small class="text-muted">{{ $tontine->frequence }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper">
                                                    <div class="progress-info">
                                                        <span class="progress-percentage">{{ $progressPercent }}%</span>
                                                        <span>{{ $userCotisations }}/{{ $totalCotisations }} séances</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-{{ $progressPercent >= 100 ? 'success' : 'primary' }}" 
                                                             role="progressbar" 
                                                             style="width: {{ $progressPercent }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="font-weight-bold text-dark">
                                                    {{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('participant.cotisations.index', ['tontine' => $tontine->id]) }}" 
                                                   class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                   data-toggle="tooltip" 
                                                   title="Voir les cotisations">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <img src="{{ asset('img/no-data.svg') }}" alt="Aucune tontine" class="img-fluid mb-4">
                            <h4>Vous ne participez à aucune tontine</h4>
                            <p class="text-muted">Rejoignez une tontine pour commencer votre expérience</p>
                            <a href="{{ route('participant.index') }}" class="btn btn-primary px-4">
                                <i class="fas fa-handshake mr-2"></i> Explorer les tontines
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Onglet Cotisations -->
                <div class="tab-pane fade" id="cotisations" role="tabpanel">
                    @if($cotisations->count())
                        <div class="timeline-vertical">
                            @foreach($cotisations as $cotisation)
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-success">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <div class="timeline-content shadow-sm">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="font-weight-bold mb-1">
                                                {{ number_format($cotisation->montant, 0, ',', ' ') }} FCFA
                                            </h5>
                                            <small class="text-muted">{{ $cotisation->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <p class="mb-2">
                                            <span class="badge badge-light border mr-2">
                                                {{ $cotisation->tontine->libelle }}
                                            </span>
                                            <span class="badge badge-info">
                                                {{ $cotisation->moyen_paiement }}
                                            </span>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-{{ $cotisation->est_valide ? 'success' : 'warning' }}">
                                                {{ $cotisation->est_valide ? 'Validée' : 'En attente' }}
                                            </span>
                                            <small class="text-muted">Séance #{{ $cotisation->numero_seance }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($cotisations->count() > 5)
                            <div class="text-center mt-4 mb-2">
                                <a href="{{ route('participant.cotisations.index') }}" class="btn btn-outline-primary">
                                    Voir toutes les cotisations ({{ $cotisations->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <img src="{{ asset('img/no-payment.svg') }}" alt="Aucune cotisation" class="img-fluid mb-4">
                            <h4>Aucune cotisation enregistrée</h4>
                            <p class="text-muted">Vous n'avez pas encore effectué de cotisation</p>
                        </div>
                    @endif
                </div>

                <!-- Onglet Tirages -->
                <div class="tab-pane fade" id="tirages" role="tabpanel">
                    @if($tirages->count())
                        <div class="row">
                            @foreach($tirages as $tirage)
                                <div class="col-lg-6 mb-4">
                                    <div class="card won-card border-left-warning shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3 text-warning">
                                                    <i class="fas fa-award fa-3x"></i>
                                                </div>
                                                <div>
                                                    <h5 class="font-weight-bold mb-1">{{ $tirage->tontine->libelle }}</h5>
                                                    <p class="mb-2">
                                                        <span class="text-warning font-weight-bold">
                                                            {{ number_format($tirage->montant, 0, ',', ' ') }} FCFA gagnés
                                                        </span>
                                                    </p>
                                                    <div class="d-flex flex-wrap">
                                                        <span class="badge badge-light border mr-2 mb-1">
                                                            <i class="fas fa-calendar-alt mr-1"></i> 
                                                            {{ $tirage->created_at->format('d/m/Y') }}
                                                        </span>
                                                        <span class="badge badge-light border mb-1">
                                                            <i class="fas fa-clock mr-1"></i> 
                                                            Séance #{{ $tirage->numero_seance }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <img src="{{ asset('img/no-win.svg') }}" alt="Aucun tirage" class="img-fluid mb-4">
                            <h4>Aucun tirage gagné</h4>
                            <p class="text-muted">Vous n'avez pas encore remporté de tirage</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Header Styles */
    .history-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        overflow: hidden;
        position: relative;
    }
    
    .history-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%239C92AC' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    /* Stat Cards */
    .stat-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .hover-scale:hover {
        transform: scale(1.03);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 1.5rem;
    }
    
    .bg-primary-light {
        background-color: rgba(78, 115, 223, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(28, 200, 138, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(246, 194, 62, 0.1);
    }

    /* Tabs */
    .nav-tabs .nav-link {
        border: none;
        color: #6e707e;
        font-weight: 600;
        padding: 1rem 1.5rem;
    }
    
    .nav-tabs .nav-link.active {
        color: #4e73df;
        background: transparent;
        border-bottom: 3px solid #4e73df;
    }

    /* Timeline */
    .timeline-vertical {
        position: relative;
        padding-left: 50px;
        margin: 0 20px;
    }
    
    .timeline-vertical::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e3e6f0;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-badge {
        position: absolute;
        left: -50px;
        top: 0;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    .timeline-content {
        background: #fff;
        padding: 1.25rem;
        border-radius: 0.35rem;
        border: 1px solid #e3e6f0;
    }

    /* Progress Bar */
    .progress-wrapper {
        margin-bottom: 0.5rem;
    }
    
    .progress-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.25rem;
    }
    
    .progress-percentage {
        font-weight: 600;
        color: #4e73df;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
    
    .empty-state img {
        max-width: 200px;
        margin-bottom: 1.5rem;
    }

    /* Won Card */
    .won-card {
        transition: all 0.3s ease;
    }
    
    .won-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    // Animation des compteurs
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Animer les compteurs
        const counters = document.querySelectorAll('.counter');
        const speed = 200;
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / speed;
            
            if (count < target) {
                const updateCount = () => {
                    const newCount = Math.ceil(count + increment);
                    counter.innerText = newCount.toLocaleString();
                    
                    if (newCount < target) {
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target.toLocaleString();
                    }
                };
                updateCount();
            } else {
                counter.innerText = target.toLocaleString();
            }
        });

        // Tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection