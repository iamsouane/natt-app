@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="card-title text-center text-primary font-weight-bold mb-4">
                        Cotisation – {{ $tontine->libelle }}
                    </h3>

                    @if(session('error'))
                        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('participant.cotisations.store', $tontine->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="numero_seance" value="{{ $seanceActuelle }}">

                        <div class="form-group mb-4">
                            <label for="montant" class="form-label font-weight-bold">Montant à cotiser</label>
                            <input type="text" name="montant" class="form-control bg-light" value="{{ number_format($montant_partiel, 2) }} FCFA" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label for="moyen_paiement" class="form-label font-weight-bold">Moyen de paiement</label>
                            <select name="moyen_paiement" class="form-control" required>
                                <option value="ESPECES">Espèces</option>
                                <option value="WAVE">Wave</option>
                                <option value="OM">Orange Money</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('participant.cotisations.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="fas fa-hand-holding-usd"></i> Cotiser
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection