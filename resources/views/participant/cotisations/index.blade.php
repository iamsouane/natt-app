@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center font-weight-bold text-primary">Mes cotisations disponibles</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom</th>
                            <th>Montant de base</th>
                            <th>Max. cotisations</th>
                            <th>Restantes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tontines as $tontine)
                        <tr>
                            <td class="font-weight-bold text-dark">{{ $tontine->libelle }}</td>
                            <td>{{ number_format($tontine->montant_de_base, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $tontine->nbre_cotisation }}</td>
                            <td>
                                @php $restantes = $tontine->cotisationsRestantesPourParticipant(Auth::id()); @endphp
                                @if($restantes == 0)
                                    <span class="badge badge-danger px-3 py-1">Complète</span>
                                @else
                                    <span class="badge badge-success px-3 py-1">{{ $restantes }}</span>
                                @endif
                            </td>
                            <td>
                                @if($restantes > 0)
                                    <a href="{{ route('participant.cotisations.create', $tontine->id) }}" class="btn btn-outline-primary btn-sm">
                                        Cotiser
                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary btn-sm" disabled>Complet</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-info mb-0">Aucune tontine disponible pour cotisation.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection