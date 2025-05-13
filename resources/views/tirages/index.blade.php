@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <div class="icon-circle bg-primary text-white me-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-dice fa-2x"></i>
                </div>
                <h1 class="fw-bold text-primary mb-0">Effectuer un Tirage</h1>
            </div>
            <p class="lead text-muted">Sélectionnez une tontine et une séance pour effectuer le tirage au sort</p>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="row mb-4">
        <div class="col-12">
            @if(session('gagnant'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-lg" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon bg-success text-white rounded-circle me-3">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1">Félicitations !</h5>
                            <p class="mb-0">Le gagnant de cette séance est <strong>{{ session('gagnant') }}</strong></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-lg" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon bg-danger text-white rounded-circle me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1">Erreur</h5>
                            <p class="mb-0">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($tontines->isEmpty())
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-body text-center py-5">
                <img src="{{ asset('img/no-data.svg') }}" alt="Aucune donnée" class="img-fluid mb-4" style="max-width: 200px;">
                <h4 class="text-gray-800">Aucune tontine disponible</h4>
                <p class="text-muted mb-4">Aucune tontine avec des participants n'est disponible pour un tirage.</p>
                <a href="{{ route('tontines.create') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus-circle mr-2"></i> Créer une tontine
                </a>
            </div>
        </div>
    @else
        <!-- Tirage Form Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-random mr-2"></i>Formulaire de tirage</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('tirages.effectuer', ['tontine' => 'placeholder', 'seance' => 'placeholder']) }}" method="GET" id="tirageForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tontine" class="form-label fw-semibold">Tontine</label>
                                    <select name="tontine" id="tontine" class="form-select shadow-sm rounded-pill" required>
                                        <option value="">-- Sélectionnez une tontine --</option>
                                        @foreach ($tontines as $tontine)
                                            <option value="{{ $tontine->id }}">{{ $tontine->libelle }} ({{ $tontine->nbre_cotisation }} séances)</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="seance" class="form-label fw-semibold">Numéro de séance</label>
                                    <input type="number" name="seance" id="seance" class="form-control shadow-sm rounded-pill" min="1" required>
                                </div>
                                
                                <div class="col-12 text-center mt-3">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm" id="tirageBtn">
                                        <i class="fas fa-dice mr-2"></i> Effectuer le tirage
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Historique Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary"><i class="fas fa-history mr-2"></i>Historique des tirages</h4>
                        <form action="{{ route('tirages.index') }}" method="GET" class="d-flex">
                            <select name="tontine_id" class="form-select form-select-sm shadow-sm rounded-pill" style="width: 200px;" onchange="this.form.submit()">
                                <option value="">Toutes les tontines</option>
                                @foreach($tontines as $tontine)
                                    <option value="{{ $tontine->id }}" {{ request('tontine_id') == $tontine->id ? 'selected' : '' }}>
                                        {{ $tontine->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Gagnant</th>
                                    <th>Contact</th>
                                    <th>Tontine</th>
                                    <th class="text-center">Séance</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tirages as $tirage)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle me-3">
                                                    {{ substr($tirage->user->prenom, 0, 1) }}{{ substr($tirage->user->nom, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $tirage->user->prenom }} {{ $tirage->user->nom }}</h6>
                                                    <small class="text-muted">{{ $tirage->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-phone-alt text-muted me-2"></i>{{ $tirage->user->telephone }}
                                        </td>
                                        <td>
                                            @if($tirage->tontine->id)
                                                <span class="badge bg-primary text-white rounded-pill">
                                                    {{ $tirage->tontine->libelle }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-white rounded-pill">
                                                    Tontine supprimée
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success text-white rounded-pill px-3 py-2">
                                                Séance #{{ $tirage->numero_seance }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <small class="text-muted">{{ $tirage->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <img src="{{ asset('img/no-data.svg') }}" alt="Aucune donnée" class="img-fluid mb-3" style="max-width: 150px;">
                                            <p class="text-muted">Aucun tirage enregistré pour le moment</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(method_exists($tirages, 'links'))
                    <div class="card-footer bg-white border-top-0 py-3">
                        {{ $tirages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-question-circle mr-2"></i>Confirmation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir effectuer le tirage pour la séance <span id="seanceNumber" class="fw-bold"></span> de la tontine <span id="tontineName" class="fw-bold"></span> ?</p>
                <p class="text-muted small">Cette action est irréversible et désignera un gagnant aléatoire parmi les participants.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="confirmTirage">Confirmer</button>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .card {
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .table th {
        border-top: none;
        border-bottom: 1px solid #e3e6f0;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #4e73df;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.03);
    }
    
    .alert-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmation modal for tirage
        const tirageForm = document.getElementById('tirageForm');
        const tontineSelect = document.getElementById('tontine');
        const seanceInput = document.getElementById('seance');
        const confirmationModal = new bootstrap.Modal('#confirmationModal');
        
        tirageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const tontineId = tontineSelect.value;
            const tontineName = tontineSelect.options[tontineSelect.selectedIndex].text.split(' (')[0];
            const seanceNumber = seanceInput.value;
            
            if (!tontineId || !seanceNumber) return;
            
            // Update modal content
            document.getElementById('seanceNumber').textContent = seanceNumber;
            document.getElementById('tontineName').textContent = tontineName;
            
            // Show modal
            confirmationModal.show();
        });
        
        document.getElementById('confirmTirage').addEventListener('click', function() {
            const tontineId = tontineSelect.value;
            const seanceNumber = seanceInput.value;
            
            // Update form action with actual values
            tirageForm.action = tirageForm.action.replace('placeholder', tontineId).replace('placeholder', seanceNumber);
            
            // Show loading state
            const btn = document.getElementById('tirageBtn');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Traitement...';
            btn.disabled = true;
            
            // Submit form
            tirageForm.submit();
        });
        
        // Reset form action when modal is hidden
        document.getElementById('confirmationModal').addEventListener('hidden.bs.modal', function() {
            tirageForm.action = "{{ route('tirages.effectuer', ['tontine' => 'placeholder', 'seance' => 'placeholder']) }}";
        });
    });
</script>
@endsection