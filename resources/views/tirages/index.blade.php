@extends('layouts.app')

@section('content')
<div class="container py-5" style="font-family: 'Segoe UI', sans-serif;">

    <h2 class="text-center mb-5 fw-bold text-primary">🎲 Effectuer un Tirage</h2>

    @if(session('gagnant'))
        <div class="alert alert-success shadow-sm rounded">
            🎉 Félicitations à <strong>{{ session('gagnant') }}</strong> pour cette séance !
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if($tontines->isEmpty())
        <div class="alert alert-warning shadow-sm rounded">
            ❌ Aucune tontine avec des participants n'est disponible pour un tirage.
        </div>
    @else
        <div class="card shadow-sm mb-5 border-0 rounded-4">
            <div class="card-body">
                <div class="text-center mb-4">
                                      
                    <p class="text-muted mt-2">Choisissez une tontine et une séance</p>
                </div>

                <form action="{{ route('tirages.effectuer', ['tontine' => 'placeholder', 'seance' => 'placeholder']) }}" method="GET">
                    <div class="mb-3">
                        <label for="tontine" class="form-label fw-semibold">Sélectionnez une Tontine :</label>
                        <select name="tontine" id="tontine" class="form-select rounded-3 shadow-sm" required>
                            <option value="">-- Choisissez une Tontine --</option>
                            @foreach ($tontines as $tontine)
                                <option value="{{ $tontine->id }}">{{ $tontine->libelle }} ({{ $tontine->nbre_cotisation }} séances)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="seance" class="form-label fw-semibold">Numéro de Séance :</label>
                        <input type="number" name="seance" id="seance" class="form-control rounded-3 shadow-sm" min="1" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary rounded-3 px-4 shadow-sm">🎲 Lancer le Tirage</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <h3 class="mb-4 text-primary">📜 Historique des Tirages</h3>

    <form action="{{ route('tirages.index') }}" method="GET" class="row g-3 mb-3">
        <div class="col-md-6">
            <select name="tontine_id" class="form-select shadow-sm" onchange="this.form.submit()">
                <option value="">-- Filtrer par Tontine --</option>
                @foreach($tontines as $tontine)
                    <option value="{{ $tontine->id }}" {{ request('tontine_id') == $tontine->id ? 'selected' : '' }}>
                        {{ $tontine->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover table-bordered align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Gagnant</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Tontine</th>
                    <th>Séance</th>
                    <th>Date du Tirage</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tirages as $tirage)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tirage->user->prenom }} {{ $tirage->user->nom }}</td>
                        <td>{{ $tirage->user->email }}</td>
                        <td>{{ $tirage->user->telephone }}</td>
                        <td>{{ $tirage->tontine->libelle }}</td>
                        <td>{{ $tirage->numero_seance }}</td>
                        <td>{{ $tirage->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Aucun tirage trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection