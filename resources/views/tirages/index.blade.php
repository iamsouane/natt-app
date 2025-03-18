@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Effectuer un Tirage</h2>

    @if(session('gagnant'))
        <div class="alert alert-success">
            🎉 Félicitations à <strong>{{ session('gagnant') }}</strong> pour cette séance !
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if($tontines->isEmpty())
        <div class="alert alert-warning">
            ❌ Aucune tontine avec des participants n'est disponible pour un tirage.
        </div>
    @else
        <form action="{{ route('tirages.effectuer', ['tontine' => 'placeholder', 'seance' => 'placeholder']) }}" method="GET">
            <div class="mb-3">
                <label for="tontine" class="form-label">Sélectionnez une Tontine :</label>
                <select name="tontine" id="tontine" class="form-control" required>
                    <option value="">-- Choisissez une Tontine --</option>
                    @foreach ($tontines as $tontine)
                        <option value="{{ $tontine->id }}">{{ $tontine->libelle }} ({{ $tontine->nbre_cotisation }} séances)</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="seance" class="form-label">Numéro de Séance :</label>
                <input type="number" name="seance" id="seance" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary">🎲 Lancer le Tirage</button>
        </form>
    @endif

    <hr class="my-5">

    <h2>Historique des Tirages</h2>

    <form action="{{ route('tirages.index') }}" method="GET" class="row mb-4">
        <div class="col-md-6">
            <select name="tontine_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Filtrer par Tontine --</option>
                @foreach($tontines as $tontine)
                    <option value="{{ $tontine->id }}" {{ request('tontine_id') == $tontine->id ? 'selected' : '' }}>
                        {{ $tontine->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
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
                    <td colspan="7" class="text-center">Aucun tirage trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection