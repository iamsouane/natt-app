@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tontines disponibles</h2>

    @if($tontines->isEmpty())
        <div class="alert alert-info">Aucune tontine disponible pour le moment.</div>
    @else
        <div class="row">
            @foreach($tontines as $tontine)
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ $tontine->libelle }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Description :</strong> {{ $tontine->description }}</p>
                            <p><strong>Montant :</strong> {{ $tontine->montant_de_base }} FCFA</p>
                            <p><strong>Participants :</strong> {{ $tontine->participants->count() }}</p>
                            <p><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection