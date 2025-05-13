@extends('layouts.app')

@section('title', 'Effectuer une Cotisation - NATT-APP')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="my-0 font-weight-bold">
                            <i class="fas fa-hand-holding-usd mr-2"></i>Nouvelle Cotisation
                        </h3>
                        <a href="{{ route('participant.cotisations.index') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left mr-1"></i> Retour
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body py-4">
                    <!-- Tontine Info -->
                    <div class="tontine-info mb-5 p-4 bg-light rounded-lg">
                        <div class="d-flex align-items-center">
                            @if($tontine->images->isNotEmpty())
                                <img src="{{ asset('storage/tontines/' . $tontine->images->first()->nom_image) }}" 
                                     class="rounded-circle mr-4" 
                                     width="80" 
                                     height="80" 
                                     alt="{{ $tontine->libelle }}"
                                     style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-4" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-handshake fa-2x"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-weight-bold text-dark mb-1">{{ $tontine->libelle }}</h4>
                                <div class="d-flex flex-wrap">
                                    <span class="badge badge-info mr-2 mb-1">
                                        <i class="fas fa-calendar-alt mr-1"></i> {{ $tontine->frequence }}
                                    </span>
                                    <span class="badge badge-success mb-1">
                                        <i class="fas fa-users mr-1"></i> {{ $tontine->participants->count() }} membres
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerts -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">Erreur!</h5>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x mr-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">Succès!</h5>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('participant.cotisations.store', $tontine->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="numero_seance" value="{{ $seanceActuelle }}">

                        <!-- Montant Field -->
                        <div class="form-group mb-4">
                            <label for="montant" class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-money-bill-wave mr-2 text-primary"></i>Montant à cotiser
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-fw fa-coins text-primary"></i>
                                    </span>
                                </div>
                                <input type="text" 
                                       id="montant" 
                                       name="montant" 
                                       class="form-control form-control-lg border-left-0 bg-light" 
                                       value="{{ number_format($montant_partiel, 0, ',', ' ') }} FCFA" 
                                       readonly
                                       style="font-weight: 600; color: #2e59d9;">
                            </div>
                        </div>

                        <!-- Payment Method Field -->
                        <div class="form-group mb-5">
                            <label for="moyen_paiement" class="font-weight-bold text-dark mb-2">
                                <i class="fas fa-mobile-alt mr-2 text-primary"></i>Moyen de paiement
                            </label>
                            <div class="payment-methods">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <input type="radio" name="moyen_paiement" value="ESPECES" id="especes" class="d-none" checked>
                                        <label for="especes" class="payment-method-card">
                                            <div class="icon-circle bg-warning text-white mb-2">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                            <span>Espèces</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <input type="radio" name="moyen_paiement" value="WAVE" id="wave" class="d-none">
                                        <label for="wave" class="payment-method-card">
                                            <div class="icon-circle" style="background-color: #1DA1F2; color: white; mb-2">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                            <span>Wave</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <input type="radio" name="moyen_paiement" value="OM" id="om" class="d-none">
                                        <label for="om" class="payment-method-card">
                                            <div class="icon-circle" style="background-color: #FF6600; color: white; mb-2">
                                                <i class="fas fa-mobile-alt"></i>
                                            </div>
                                            <span>Orange Money</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-group mt-5 pt-3 border-top">
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-redo mr-2"></i> Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-success px-5 shadow-sm">
                                    <i class="fas fa-check-circle mr-2"></i> Confirmer la cotisation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .payment-method-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 0.5rem;
        border: 2px solid #e3e6f0;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method-card:hover {
        border-color: #4e73df;
        background-color: rgba(78, 115, 223, 0.05);
    }

    input[type="radio"]:checked + .payment-method-card {
        border-color: #4e73df;
        background-color: rgba(78, 115, 223, 0.1);
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .tontine-info {
        border-left: 4px solid #4e73df;
        transition: all 0.3s ease;
    }

    .tontine-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-control:read-only {
        background-color: #f8f9fc;
    }
</style>
@endsection

@section('scripts')
<script>
    // Validation Bootstrap
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Animation for payment method selection
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.payment-method-card').forEach(c => {
                c.style.transform = 'scale(1)';
            });
            this.style.transform = 'scale(1.05)';
        });
    });
</script>
@endsection